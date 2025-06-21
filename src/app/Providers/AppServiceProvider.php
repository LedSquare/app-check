<?php

namespace App\Providers;

use App\Configs\UrlConfig;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UrlConfig::class, fn () => new UrlConfig(app()->make(Request::class)));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
