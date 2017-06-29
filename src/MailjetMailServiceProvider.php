<?php

namespace Mailjet\LaravelMailjet;

use Illuminate\Mail\MailServiceProvider;
use Mailjet\LaravelMailjet\Transport\MailjetTransport;

class MailjetMailServiceProvider extends MailServiceProvider
{
    /**
     * Extended register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftTransport()
    {
        parent::registerSwiftTransport();
        app('swift.transport')->extend('mailjet', function ($app) {
            $config = $this->app['config']->get('services.mailjet', array());
            $call = $this->app['config']->get('services.mailjet.transactionnal.call', true);
            $options = $this->app['config']->get('services.mailjet.transactionnal.options', array());

            return new MailjetTransport(new \Swift_Events_SimpleEventDispatcher(), $config['key'], $config['secret'], $call, $options);
        });
    }
}
