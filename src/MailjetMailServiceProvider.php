<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet;

use Illuminate\Mail\MailServiceProvider;
use Mailjet\LaravelMailjet\Transport\MailjetTransport;
use Swift_Events_SimpleEventDispatcher as EventDispatcher;

class MailjetMailServiceProvider extends MailServiceProvider
{
    /**
     * Extended register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftTransport(): void
    {
        parent::registerSwiftTransport();

        app('swift.transport')->extend('mailjet', function () {
            $config = $this->app['config']->get('services.mailjet', []);
            $call = $this->app['config']->get('services.mailjet.transactional.call', true);
            $options = $this->app['config']->get('services.mailjet.transactional.options', []);

            return new MailjetTransport(new EventDispatcher(), $config['key'], $config['secret'], $call, $options);
        });
    }
}
