<?php

use Illuminate\Support\Facades\Route;
use Modules\Shopping\App\Livewire\Page\Cart;
use Modules\Shopping\App\Livewire\Page\checkout;
use Modules\Shopping\App\Livewire\Page\Payment;

// Rotas do módulo Shopping

// Página pública
Route::middleware(['web'])->group(function () {
    Route::get('/pagar', Payment::class)
        ->name('payment');

    Route::get('/carrinho', Cart::class)
        ->name('cart');

    Route::get('/cliente', checkout::class)
        ->name('checkout');
});
