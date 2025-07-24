<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\App\Livewire\Page\ProductIndex;
use Modules\Products\App\Livewire\Admin\ProductEdit;
use Modules\Products\App\Livewire\Admin\ProductForm;
use Modules\Products\App\Livewire\Admin\ProductList;

Route::name('products.')->group(function () {
    // Rotas do módulo Products

    // // Página pública
    Route::middleware(['web'])->group(function () {
        Route::get('/produtos', ProductIndex::class)
            ->name('products');
    });
    // Painel admin (autenticado e verificado)
    Route::middleware(['web', 'auth', 'verified'])->prefix('admin/cadastros')->group(function () {
        // URL: /admin/lista-de-produtos
        Route::get('lista-de-produtos', ProductList::class)->name('products-list');

        // URL: /admin/produtos/novo
        Route::get('produtos/novo', ProductForm::class)->name('product-novo');

        // URL: /admin/produtos/{products}/editar
        // Considere usar {product} no singular para injeção de modelo, ex: produtos/{product}/editar
        Route::get('produtos/{products}/editar', ProductEdit::class)->name('product-edit');
    });
});

// Inclui as rotas de autenticação da aplicação principal
require base_path('routes/auth.php');


// require __DIR__ . '/auth.php';
