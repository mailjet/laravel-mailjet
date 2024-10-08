<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Providers;

use Illuminate\Support\ServiceProvider;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Services\ContactsListService;
use Mailjet\LaravelMailjet\Contracts\ContactsListContract;

class ContactsListServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ContactsListContract::class, function () {
            $config = $this->app['config']->get('services.mailjet', []);
            $call = $this->app['config']->get('services.mailjet.common.call', true);
            $options = $this->app['config']->get('services.mailjet.common.options', []);

            $mailjetService = new MailjetService($config['key'], $config['secret'], $call, $options);

            return new ContactsListService($mailjetService);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [ContactsListContract::class];
    }
}
