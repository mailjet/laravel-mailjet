<?php

namespace Mailjet\LaravelMailjet\Tests\Services;

use Mockery\Container;
use Orchestra\Testbench\TestCase;

class MailjetServiceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testFacade()
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

    public function testCanUseClient()
    {
        $client = \Mailjet::getClient();
        $this->assertEquals("Mailjet\Client", get_class($client));
    }



    protected function getPackageAliases($app)
    {
        return [
            'Mailjet' => \Mailjet\LaravelMailjet\Facades\Mailjet::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('services.mailjet.key', 'ABC123456');
        $app['config']->set('services.mailjet.secret', 'ABC123456');
    }

    protected function getPackageProviders($app)
    {
        return ['\Mailjet\LaravelMailjet\MailjetServiceProvider'];
    }
}
