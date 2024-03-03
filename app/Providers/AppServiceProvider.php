<?php

namespace App\Providers;

use App\Service\UrlChecker\UrlChecker;
use App\Service\UrlChecker\UrlCheckerInterface;
use App\Service\UrlChecker\UrlCheckerLocal;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env('app_env') === 'prod') {
            $this->app->bind(UrlCheckerInterface::class, function ($app) {
                // Retrieve the value of the environment variable
                $apiUrl = env('VIRUSTOTAL_API_KEY');

                // Return an instance of ApiService with the environment variable value injected
                return new UrlChecker($apiUrl);
            });
        } else {
            $this->app->bind(UrlCheckerInterface::class, function ($app) {
                return new UrlCheckerLocal();
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
