<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Tests\Providers;

use Illuminate\Support\Facades\Mail;
use Orchestra\Testbench\TestCase;
use Mailjet\LaravelMailjet\MailjetServiceProvider;
use Symfony\Component\Mailer\Transport\TransportInterface;

class MailjetServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function it_registers_mailjet_mail_driver(): void
    {
        $transport = Mail::mailer('mailjet')->getSymfonyTransport();
        
        $this->assertInstanceOf(TransportInterface::class, $transport);
    }

    /**
     * @test
     */
    public function it_creates_transport_without_sandbox_by_default(): void
    {
        $transport = Mail::mailer('mailjet')->getSymfonyTransport();
        
        // The transport string representation should NOT contain sandbox
        $transportString = (string) $transport;
        
        $this->assertStringNotContainsString('sandbox', $transportString);
    }

    /**
     * @test
     */
    public function it_creates_transport_with_sandbox_when_enabled(): void
    {
        // Enable sandbox mode
        config(['services.mailjet.sandbox' => true]);
        
        // Re-register the provider to pick up new config
        $this->app->register(MailjetServiceProvider::class, true);
        
        $transport = Mail::mailer('mailjet')->getSymfonyTransport();
        
        // The transport string representation should contain sandbox
        $transportString = (string) $transport;
        
        $this->assertStringContainsString('sandbox', $transportString);
    }

    /**
     * @test
     */
    public function it_provides_mailjet_service(): void
    {
        $provider = new MailjetServiceProvider($this->app);
        
        $this->assertContains('mailjet', $provider->provides());
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('services.mailjet.key', 'test_api_key');
        $app['config']->set('services.mailjet.secret', 'test_api_secret');
        $app['config']->set('services.mailjet.sandbox', false);
        
        $app['config']->set('mail.mailers.mailjet', [
            'transport' => 'mailjet',
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [MailjetServiceProvider::class];
    }
}
