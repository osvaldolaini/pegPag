<?php

namespace Modules\Shopping;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ShoppingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', strtolower('Shopping'));
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Livewire::component('page.cart-index', \Modules\Shopping\App\Livewire\Page\Cart::class);
        Livewire::component('page.count-cart', \Modules\Shopping\App\Livewire\Page\CountCart::class);
        Livewire::component('page.checkout-index', \Modules\Shopping\App\Livewire\Page\Checkout::class);
        Livewire::component('page.shopping-index', \Modules\Shopping\App\Livewire\Page\Payment::class);
    }

    public function register(): void
    {
        //
    }
}
