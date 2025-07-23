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

        // Carrega as views do módulo
        // IMPORTANTE: O segundo parâmetro 'products' é o namespace que você usa
        // para views como 'products::admin.product-form'
        $this->loadViewsFrom(__DIR__ . '/resources/views/livewire', strtolower('Products'));
        // Se suas views Blade estiverem em 'resources/views' (e não 'resources/views/livewire'),
        // ajuste o caminho acima para: $this->loadViewsFrom(__DIR__ . '/resources/views', strtolower('Products'));

        // Carrega as migrações do módulo
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Livewire::component('admin.product-form', \Modules\Products\App\Livewire\Admin\ProductForm::class);

        // Se você tiver outros componentes neste módulo, registre-os de forma semelhante:
        Livewire::component('page.product-index', \Modules\Products\App\Livewire\Page\ProductIndex::class);
        Livewire::component('admin.product-edit', \Modules\Products\App\Livewire\Admin\ProductEdit::class);
        Livewire::component('admin.product-list', \Modules\Products\App\Livewire\Admin\ProductList::class);
    }

    public function register(): void
    {
        //
    }
}
