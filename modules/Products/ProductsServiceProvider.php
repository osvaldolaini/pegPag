<?php

namespace Modules\Products;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;


class ProductsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Carrega as rotas do módulo
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views/livewire', strtolower('Products'));
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Se você tiver outros componentes neste módulo, registre-os de forma semelhante:
        Livewire::component('page.product-index', \Modules\Products\App\Livewire\Page\ProductIndex::class);
        Livewire::component('admin.product-form', \Modules\Products\App\Livewire\Admin\ProductForm::class);
        Livewire::component('admin.product-edit', \Modules\Products\App\Livewire\Admin\ProductEdit::class);
        Livewire::component('admin.product-list', \Modules\Products\App\Livewire\Admin\ProductList::class);
    }

    public function register(): void
    {
        //
    }
}
