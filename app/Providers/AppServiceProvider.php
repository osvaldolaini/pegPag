<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Auth; // Para verificar o Auth

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // AppServiceProvider.php

        foreach (glob(base_path('modules/*'), GLOB_ONLYDIR) as $modulePath) {
            $provider = $modulePath . '/' . basename($modulePath) . 'ServiceProvider.php';
            if (file_exists($provider)) {
                $namespace = 'Modules\\' . basename($modulePath) . '\\' . basename($modulePath) . 'ServiceProvider';
                $this->app->register($namespace);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(RouteMatched::class, function (RouteMatched $event) {
        //     $routeName = $event->route->getName();
        //     $routeUri = $event->route->uri();
        //     $routeMiddlewares = $event->route->gatherMiddleware(); // Pega todos os middlewares aplicados

        //     // Verifique se é a rota que você está debugando
        //     if (str_contains($routeUri, 'lista-de-produtos') || str_contains($routeUri, 'admin-products/lista')) {
        //         echo "Tentando acessar Rota: {$routeUri} (Nome: {$routeName})<br>";
        //         echo "Middlewares Aplicados: " . implode(', ', array_map(function ($m) {
        //             return is_string($m) ? $m : 'Closure/Object';
        //         }, $routeMiddlewares)) . "<br>";
        //         echo "Usuário Autenticado: " . (Auth::check() ? 'Sim' : 'Não') . "<br>";
        //         echo "ID do Usuário: " . (Auth::id() ?? 'N/A') . "<br>";
        //         dd("Informações da Rota Coletadas."); // Para parar a execução e ver a saída
        //     }
        // });
    }
}
