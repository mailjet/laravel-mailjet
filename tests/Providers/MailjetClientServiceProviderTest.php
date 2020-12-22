<?php

namespace Mailjet\LaravelMailjet\Tests\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Mockery;
use Orchestra\Testbench\TestCase;
use Mailjet\LaravelMailjet\Providers\MailjetClientServiceProvider;

class MailjetClientServiceProviderTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $application_mock;

    /**
     * @var ServiceProvider
     */
    protected $service_provider;

    protected function setUp(): void
    {
        $this->setUpMocks();

        $this->service_provider = new MailjetClientServiceProvider($this->application_mock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->application_mock = Mockery::mock(Application::class);
        $this->application_mock->shouldReceive('bind');
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->service_provider);
    }

    /**
     * @test
     */
    public function it_does_provide_method()
    {
        $this->assertContains('Mailjet\LaravelMailjet\Contracts\MailjetServiceContract', $this->service_provider->provides());
    }

    /**
     * @test
     */
    public function it_performs_nothing_in_a_boot_method()
    {
        $this->assertNull($this->service_provider->boot());
    
    }
}