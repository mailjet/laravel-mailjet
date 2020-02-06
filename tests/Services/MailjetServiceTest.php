<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Tests\Services;

use Mailjet\Client;
use Orchestra\Testbench\TestCase;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use Mailjet\LaravelMailjet\MailjetServiceProvider;

class MailjetServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testFacade(): void
    {
        $this->assertTrue(method_exists($this->app['Mailjet'], 'get'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'post'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'put'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'delete'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'getAllLists'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'createList'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'getListRecipients'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'getSingleContact'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'createContact'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'createListRecipient'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'editListrecipient'));
        $this->assertTrue(method_exists($this->app['Mailjet'], 'getClient'));
    }

    public function testCanUseClient(): void
    {
        $client = Mailjet::getClient();
        $this->assertInstanceOf(Client::class, $client);
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Mailjet' => Mailjet::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('services.mailjet.key', 'ABC123456');
        $app['config']->set('services.mailjet.secret', 'ABC123456');
    }

    protected function getPackageProviders($app): array
    {
        return [MailjetServiceProvider::class];
    }
}
