<?php

namespace MoltenCore\LaravelMailjet;

use Illuminate\Mail\MailServiceProvider;
use MoltenCore\LaravelMailjet\Transport\MailjetTransport;

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
            return new MailjetTransport(new \Swift_Events_SimpleEventDispatcher(), $config['key'], $config['secret']);
        });
    }
}
