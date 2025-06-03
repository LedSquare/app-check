<?php

namespace Aspect\Providers;

use Aspect\Interfaces\Actions\AspectUnit\AspectActionInterface;
use Aspect\Units\AspectV1Unit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class AspectDomainServiceProvider extends ServiceProvider
{

    public array $bindings = [
        AspectActionInterface::class => AspectV1Unit::class,
    ];

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->prefix('aspect')
                ->group(__DIR__ . '/../../routes/aspect.php');
        });
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
