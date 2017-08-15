<?php

namespace Mailjet\LaravelMailjet\Tests\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Mockery;
use Mailjet\LaravelMailjet\Providers\CampaignDraftServiceProvider;

class CampaignDraftServiceProviderTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $application_mock;

    /**
     * @var ServiceProvider
     */
    protected $service_provider;

    protected function setUp()
    {
        $this->setUpMocks();

        $this->service_provider = new CampaignDraftServiceProvider($this->application_mock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->application_mock = Mockery::mock(Application::class);
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
    public function it_does_register_method()
    {
        $this->assertTrue($this->service_provider->register());
    }

    /**
     * @test
     */
    public function it_performs_nothing_in_a_boot_method()
    {
        $this->assertNull($this->service_provider->boot());
    
    }
}