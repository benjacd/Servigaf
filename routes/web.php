<?php

use App\Http\Controllers\Admin\CategoryGroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\TransbankController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestController::class, 'index'])->name("landing");
Route::get('product/{product}', [GuestController::class, 'show'])->name('guest.product.show');
Route::get('/Cart', [GuestController::class, 'show_cart'])->name('mostrar_carro');
Route::get('/Category/{group}', [GuestController::class, 'show_category'])->name('mostrar_categoria');
Route::get('/Agendar', [GuestController::class, 'agendarHora'])->name("agendar");

Route::view('/mediosDePago', 'posts.mediosDePago')->name('mediosDePago');
Route::view('/comoComprar', 'posts.comoComprar')->name('comoComprar');
Route::view('/envios', 'posts.envios')->name('envios');

Route::resource('client', ClientController::class)->only(['create', 'store', 'edit', 'update']);

Route::prefix('transbank')->as('transbank.')->group(function () {
    Route::get('payment', [CreateClientController::class, 'createTransactionAndRedirect'])->name('create');
    Route::get('createTransaction', [TransbankController::class, 'createdTransaction'])->name('createTransaction');
    Route::any('returnUrl', [TransbankController::class, 'commitTransaction'])->name('returnUrl');
    Route::view('thanks', 'webpayplus.transaction_committed')->name('finished');
});


Route::get('boleta/{buy_order}', function (string $buy_order){
    $transaction = \App\Models\Transaction::where('buy_order', $buy_order)
        ->where('was_payed', TRUE)
        ->with(['client', 'products'])
        ->firstOrFail();

    return (new \App\Services\InvoiceService())->create($transaction->client, $transaction);
})->name('boleta');

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::resource('groups', CategoryGroupController::class)->except(['create', 'show']);
    Route::resource('categories', CategoryController::class)->except(['index', 'create', 'show']);
});

Route::middleware('auth', 'role:cliente')->prefix('/customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/client/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/update', [ClientController::class, 'update'])->name('client.update');
    Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');
});

Route::get('/posts', function () {
    return view('posts.index');
});

require __DIR__.'/auth.php';

Route::get('/welcome', function (){
    return view('welcome');
});

Route::get('/search', [GuestController::class, 'search'])->name("search");
