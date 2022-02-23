<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Symfony\Component\Mailer\Bridge\Mailjet\Transport\MailjetTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class MailjetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Mail::extend('mailjet', function () {
            return (new MailjetTransportFactory)->create(
                new Dsn(
                    'mailjet+api',
                    'default',
                    config('services.mailjet.key'),
                    config('services.mailjet.secret')
                )
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('Mailjet', function () {
            $config = $this->app['config']->get('services.mailjet', []);
            $call = $this->app['config']->get('services.mailjet.common.call', true);
            $options = $this->app['config']->get('services.mailjet.common.options', []);

            return new MailjetService($config['key'], $config['secret'], $call, $options);
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return ['mailjet'];
    }
}
