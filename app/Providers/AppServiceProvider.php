<?php

namespace App\Providers;

use App\Clients\ExternalApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(ExternalApiClient::class, function ($app) {
            return new ExternalApiClient('237cd6a8-5a0e-4ff0-b7e2-0bf34675d058');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
