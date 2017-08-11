<?php

namespace Mailjet\LaravelMailjet\Providers;

use Illuminate\Support\ServiceProvider;
use Mailjet\LaravelMailjet\Services\CampaignDraftService;
use Mailjet\LaravelMailjet\Services\MailjetService;

class CampaignDraftServiceProvider extends ServiceProvider
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
        $this->app->singleton('CampaignDraft', function ($app) {
            $config = $this->app['config']->get('services.mailjet', array());
            $call = $this->app['config']->get('services.mailjet.common.call', true);
            $options = $this->app['config']->get('services.mailjet.common.options', array());
            return new CampaignDraftService(new MailjetService($config['key'], $config['secret'], $call, $options));
        });
    }


    public function provides()
    {
        return ['CampaignDraft'];
    }
}