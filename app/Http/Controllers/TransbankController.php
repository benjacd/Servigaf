<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitTransactionRequest;
use App\Models\Client;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\InvoiceService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Transbank\Webpay\WebpayPlus;

class TransbankController extends Controller
{
    public function __construct()
    {
        if (app()->environment('production')) {
            WebpayPlus::configureForProduction(config('services.transbank.webpay_plus_cc'), config('services.transbank.webpay_plus_api_key'));
        } else {
            WebpayPlus::configureForTesting();
        }
    }

    public function createdTransaction()
    {
        \Log::info('Entrando a createdTransaction');

        if (Session::missing('transaction')) {
            \Log::warning('Falta transacción en la sesión, redirigiendo a mostrar_carro');
            return redirect()->route('mostrar_carro')->withErrors(['Transactionless' => 'Ha ocurrido un error en la transacción']);
        }
        $transaction = Session::get('transaction');
        \Log::info('Transacción encontrada en la sesión', ['transaction' => $transaction]);

        if (auth()->guest()) {
            \Log::warning('Usuario no autenticado, redirigiendo a login');
            return redirect()->route('login')->withErrors(['message' => 'Debes iniciar sesión para continuar con la compra.']);
        }

        if (!auth()->user()->client) {
            \Log::warning('Usuario no tiene cliente, redirigiendo a client.create');
            return redirect()->route('client.create')->withErrors(['message' => 'Debes completar tus datos de cliente para continuar con la compra.']);
        }

        \Log::info('Creando transacción en WebpayPlus');
        $resp = WebpayPlus::transaction()
            ->create(
                $transaction->buy_order,
                Session::getId(),
                $transaction->final_price,
                route('transbank.returnUrl')
            );

        return view('webpayplus/transaction_created', compact('resp'));
    }

    public function commitTransaction(CommitTransactionRequest $request)
    {
        $token = $request->input('token_ws');
        \Log::error('se entro a commit transaction');
        if (!$token) {
            \Log::error('Falta token en la respuesta');
            return redirect()->route('mostrar_carro')->withErrors([
                'Transacción anormal' => 'Ocurrió un error inesperado al momento de procesar la transacción.'
            ]);
        }

        \Log::info('Comitiendo transacción en WebpayPlus');
        $resp = WebpayPlus::transaction()->commit($token);

        if (!$resp->isApproved()) {
            \Log::warning('Transacción no aprobada', ['resp' => $resp]);
            return redirect()->route('mostrar_carro')->withErrors([
                'Aprobación' => 'La compra no fue aprobada por tu banco.'
            ]);
        }

        \Log::info('Transacción aprobada', ['resp' => $resp]);
        Transaction::where('buy_order', $resp->getBuyOrder())->update(['was_payed' => true]);

        foreach (Cart::content() as $product) {
            $productModel = Product::find($product->id);
            $productModel->decrement('stock', $product->qty);
        }

        Cart::destroy();

        return redirect()->route('transbank.finished');
    }
}
