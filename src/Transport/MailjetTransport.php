<?php

namespace MoltenCore\LaravelMailjet\Transport;

use Mailjet\MailjetSwiftMailer\SwiftMailer\MailjetTransport as BaseTransport;

class MailjetTransport extends BaseTransport
{

    /**
     * The plug-ins registered with the transport.
     *
     * @var array
     */
    public $plugins = [];

    /**
     * Register a plug-in with the transport.
     *
     * @param  \Swift_Events_EventListener  $plugin
     * @return void
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        array_push($this->plugins, $plugin);
    }

    /**
     * Iterate through registered plugins and execute plugins' methods.
     *
     * @param  \Swift_Mime_Message  $message
     * @return void
     */
    protected function beforeSendPerformed(Swift_Mime_Message $message)
    {
        $event = new Swift_Events_SendEvent($this, $message);
        foreach ($this->plugins as $plugin) {
            if (method_exists($plugin, 'beforeSendPerformed')) {
                $plugin->beforeSendPerformed($event);
            }
        }
    }
}
