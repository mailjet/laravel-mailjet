<?php

namespace Mailjet\LaravelMailjet;

use Exception;
use Illuminate\Mail\MailServiceProvider;
use Mailjet\LaravelMailjet\Transport\MailjetTransport;
use Swift_Events_SimpleEventDispatcher as EventDispatcher;

class MailjetMailServiceProvider extends MailServiceProvider
{
    /**
     * Extended register the Illuminate Mailer instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer(): void
    {
        parent::registerIlluminateMailer();

        try {
            app('mail.manager')->extend('mailjet', function () {
                return $this->mailjetTransport();
            });
        } catch (Exception $e) {
            app('swift.transport')->extend('mailjet', function () {
                return $this->mailjetTransport();
            });
        }
    }

    /**
     * Return configured MailjetTransport.
     *
     * @return MailjetTransport
     */
    protected function mailjetTransport(): MailjetTransport
    {
        $config = $this->app['config']->get('services.mailjet', []);
        $call = $this->app['config']->get('services.mailjet.transactional.call', true);
        $options = $this->app['config']->get('services.mailjet.transactional.options', []);

        return new MailjetTransport(new EventDispatcher(), $config['key'], $config['secret'], $call, $options);
    }
}
