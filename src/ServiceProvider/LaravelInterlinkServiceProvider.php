<?php


namespace KaqazStudio\LaravelInterlink\ServiceProvider;

use KaqazStudio\LaravelInterlink\LaravelInterlink;
use Illuminate\Support\ServiceProvider;

class LaravelInterlinkServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('laravel_interlink', function () {
            return new LaravelInterlink();
        });
    }
}
