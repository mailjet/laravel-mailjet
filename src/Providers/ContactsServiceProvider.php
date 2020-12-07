<?php

namespace Mailjet\LaravelMailjet\Providers;

use Illuminate\Support\ServiceProvider;
use Mailjet\LaravelMailjet\Contracts\ContactsV4Contract;
use Mailjet\LaravelMailjet\Services\ContactsV4Service;
use Mailjet\LaravelMailjet\Services\MailjetService;

class ContactsServiceProvider extends ServiceProvider
{
    protected $defer = true;

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
        $this->app->bind(ContactsV4Service::class, function($app) {
            $config = $this->app['config']->get('services.mailjet', []);
            $call = $this->app['config']->get('services.mailjet.v4.call', true);
            $options = $this->app['config']->get('services.mailjet.v4.options', []);

            $mailjetService = new MailjetService($config['key'], $config['secret'], $call, $options);

            return new ContactsV4Service($mailjetService);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ContactsV4Service::class];
    }
}