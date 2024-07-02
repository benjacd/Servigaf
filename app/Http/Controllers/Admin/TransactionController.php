<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $client = $user->client;

        $query = Transaction::query();

        if (!$client) {
            // Administrator view
            $query->where('was_payed', true);
        } else {
            // Client view
            $query->where('client_id', $client->id)
                  ->where('was_payed', true);
        }

        // Apply date filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $transactions = $query->with('products', 'client')
                              ->orderByDesc('updated_at')
                              ->paginate(10);

        if (!$client) {
            return view('admin.transactions.index', compact('transactions', 'client'));
        } else {
            return view('user.transactions.index', compact('transactions', 'client'));
        }
    }

    public function markAsSent(Transaction $transaction)
    {
        $transaction->was_received = true;
        $transaction->save();

        return redirect()->route('transactions.index')->with('status', 'Transaction marked as sent.');
    }

    public function markAsNotSent(Transaction $transaction)
    {
        $transaction->was_received = false;
        $transaction->save();

        return redirect()->route('transactions.index')->with('status', 'Transaction marked as not sent.');
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function show(Transaction $transaction): RedirectResponse
    {
        return redirect()->route('boleta', $transaction->buy_order);
    }

}
