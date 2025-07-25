<?php

namespace Modules\Stores;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class StoresServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', strtolower('Stores'));
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Livewire::component('page.store-index', \Modules\Stores\App\Livewire\Page\StoreIndex::class);
        Livewire::component('admin.store-form', \Modules\Stores\App\Livewire\Admin\StoreForm::class);
        Livewire::component('admin.store-edit', \Modules\Stores\App\Livewire\Admin\StoreEdit::class);
        Livewire::component('admin.store-list', \Modules\Stores\App\Livewire\Admin\StoreList::class);
        Livewire::component('admin.store-product', \Modules\Stores\App\Livewire\Admin\StoreProduct::class);
    }

    public function register(): void
    {
        //
    }
}
