<?php

namespace MoltenCore\LaravelMailjet;

use Illuminate\Support\ServiceProvider;
use MoltenCore\LaravelMailjet\Services\MailjetService;

class MailjetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Facade
        $this->app->singleton('Mailjet', function ($app) {
            return new MailjetService();
        });
    }


    public function provides()
    {
        return ['mailjet'];
    }
}
