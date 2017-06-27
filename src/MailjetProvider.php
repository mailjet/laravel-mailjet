<?php

namespace MoltenCore\LaravelMailjet;

use Illuminate\Support\ServiceProvider;
use laravelMailjet\Services\MailJetService;

class MailjetProvider extends ServiceProvider
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
        $this->app->singleton('mailJet', function ($app) {
            return new MailJetService();
        });
    }

    public function provides()
    {
        return ['mailjet'];
    }
}
