<?php

namespace Modules\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', strtolower('Blog'));
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register(): void
    {
        //
    }
}