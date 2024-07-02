<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Transaction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CreateClientController extends Controller
{
    public function createTransactionAndRedirect()
{
    \Log::info('Entrando a createTransactionAndRedirect');

    $client = auth()->user()->client;

    if (!$client) {
        \Log::warning('No se encontró cliente, redirigiendo a client.create');
        return redirect()->route('client.create')->withErrors(['message' => 'Debes completar tus datos de cliente para continuar con la compra.']);
    }

    \Log::info('Cliente encontrado, creando transacción');

    $transaction = Transaction::create([
        'client_id' => $client->id,
        'final_price' => (int) Cart::subtotal(0, '', '') + 3000, //precio de envio
        'buy_order' => now()->format("Ymdhis")
    ]);

    foreach (Cart::content() as $product) {
        Order::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'amount' => $product->qty,
            'total_price' => $product->qty * $product->price,
        ]);
    }

    session(['transaction' => $transaction]);

    \Log::info('Transacción creada, redirigiendo a transbank.createTransaction');

    return redirect()->route('transbank.createTransaction');
}

}

