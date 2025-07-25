<?php

use Illuminate\Support\Facades\Route;
use Modules\Stores\App\Livewire\Page\StoreIndex;
use Modules\Stores\App\Livewire\Admin\StoreEdit;
use Modules\Stores\App\Livewire\Admin\StoreForm;
use Modules\Stores\App\Livewire\Admin\StoreList;
use Modules\Stores\App\Livewire\Admin\StoreProduct;

// Rotas do módulo Stores

// Página pública
Route::name('stores.')->group(function () {
    // Rotas do módulo stores

    // // Página pública
    Route::middleware(['web'])->group(function () {
        Route::get('/lojas', StoreIndex::class)
            ->name('stores');
    });
    // Painel admin (autenticado e verificado)
    Route::middleware(['web', 'auth', 'verified'])->prefix('admin/cadastros')->group(function () {
        // URL: /admin/lista-de-lojas
        Route::get('lista-de-lojas', StoreList::class)->name('stores-list');

        // URL: /admin/lojas/novo
        Route::get('lojas/novo', StoreForm::class)->name('store-novo');

        // URL: /admin/lojas/{stores}/editar
        // Considere usar {Store} no singular para injeção de modelo, ex: lojas/{Store}/editar
        Route::get('lojas/{stores}/editar', StoreEdit::class)->name('store-edit');

        Route::get('lojas/{stores}/produtos', StoreProduct::class)->name('store-product');
    });
});

// Inclui as rotas de autenticação da aplicação principal
require base_path('routes/auth.php');
