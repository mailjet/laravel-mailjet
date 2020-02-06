<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Tests\Providers;

use Mockery;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Mailjet\LaravelMailjet\Contracts\EventCallbackUrlContract;
use Mailjet\LaravelMailjet\Providers\EventCallbackUrlServiceProvider;

class EventCallbackUrlServiceProviderTest extends TestCase
{
    /**
     * @var Application|Mockery\Mock
     */
    protected $application;

    /**
     * @var ServiceProvider
     */
    protected $serviceProvider;

    protected function setUp(): void
    {
        $this->setUpMocks();

        $this->serviceProvider = new EventCallbackUrlServiceProvider($this->application);

        parent::setUp();
    }

    /**
     * @test
     */
    public function it_can_be_constructed(): void
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->serviceProvider);
    }

    /**
     * @test
     */
    public function it_does_provide_method(): void
    {
        $this->assertContains(EventCallbackUrlContract::class, $this->serviceProvider->provides());
    }

    /**
     * @test
     */
    public function it_performs_nothing_in_a_boot_method(): void
    {
        $this->assertNull($this->serviceProvider->boot());
    }

    protected function setUpMocks(): void
    {
        $this->application = Mockery::mock(Application::class);
        $this->application->shouldReceive('bind');
    }
}
