<?php

namespace Mailjet\LaravelMailjet\Tests\Services;

use Mailjet\Client;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\Resources;
use Mailjet\Response;
use Mockery;
use Orchestra\Testbench\TestCase;

class MailjetServiceTest extends TestCase
{
    /**
     * @var Client|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $mailjetClientMock;

    /**
     * @var MailjetService
     */
    private $mailjetService;

    public function setUp(): void
    {
        parent::setUp();

        $responseMock = $this->createMock(Response::class);
        $responseMock->method('success')->willReturn(true);

        $this->mailjetClientMock = Mockery::mock('overload:' . Client::class);

        $this->mailjetClientMock
            ->shouldReceive('put')
            ->andReturnUsing(function($resourceArg, $params) use ($responseMock) {
                $data = [];

                switch ($resourceArg) {
                    case 'resource-test-put':
                        $data = array_merge($params, [
                            'status' => '0003',
                        ]);
                        break;

                    case Resources::$Listrecipient:
                        $data = array_merge($params, [
                            'status' => '0011',
                        ]);
                        break;
                }

                $responseMock->method('getData')->willReturn($data);

                return $responseMock;
            });

        $this->mailjetClientMock
            ->shouldReceive('post')
            ->andReturnUsing(function($resourceArg, $params) use ($responseMock) {
                $data = [];

                switch ($resourceArg) {
                    case 'resource-test-post':
                        $data = array_merge($params, [
                            'status' => '0001',
                        ]);
                        break;

                    case Resources::$Contactslist:
                        $data = array_merge($params, [
                            'status' => '0006',
                        ]);
                        break;

                    case Resources::$Contact:
                        $data = array_merge($params, [
                            'status' => '0009',
                        ]);
                        break;

                    case Resources::$Listrecipient:
                        $data = array_merge($params, [
                            'status' => '0010',
                        ]);
                        break;

                }

                $responseMock->method('getData')->willReturn($data);

                return $responseMock;
            });

        $this->mailjetClientMock
            ->shouldReceive('delete')
            ->andReturnUsing(function($resourceArg, $params) use ($responseMock) {
                $data = [];

                switch ($resourceArg) {
                    case 'resource-test-delete':
                        $data = array_merge($params, [
                            'status' => '0004',
                        ]);
                        break;
                }

                $responseMock->method('getData')->willReturn($data);

                return $responseMock;
            });

        $this->mailjetClientMock
            ->shouldReceive('get')
            ->andReturnUsing(function($resourceArg, $params) use ($responseMock) {
                $data = [];

                switch ($resourceArg) {
                    case 'resource-test-get':
                        $data = array_merge($params, [
                            'status' => '0002',
                        ]);
                        break;

                    case Resources::$Contactslist:
                        $data = array_merge($params, [
                            'status' => '0005',
                        ]);
                        break;

                    case Resources::$Listrecipient:
                        $data = array_merge($params, [
                            'status' => '0007',
                        ]);
                        break;

                    case Resources::$Contact:
                        $data = array_merge($params, [
                            'status' => '0008',
                        ]);
                        break;
                }

                $responseMock->method('getData')->willReturn($data);

                return $responseMock;
            });

        $this->mailjetService = $this->app['Mailjet'];
    }

    public function testFacade()
    {
        $this->assertTrue(method_exists($this->mailjetService, 'get'));
        $this->assertTrue(method_exists($this->mailjetService, 'post'));
        $this->assertTrue(method_exists($this->mailjetService, 'put'));
        $this->assertTrue(method_exists($this->mailjetService, 'delete'));
        $this->assertTrue(method_exists($this->mailjetService, 'getAllLists'));
        $this->assertTrue(method_exists($this->mailjetService, 'createList'));
        $this->assertTrue(method_exists($this->mailjetService, 'getListRecipients'));
        $this->assertTrue(method_exists($this->mailjetService, 'getSingleContact'));
        $this->assertTrue(method_exists($this->mailjetService, 'createContact'));
        $this->assertTrue(method_exists($this->mailjetService, 'createListRecipient'));
        $this->assertTrue(method_exists($this->mailjetService, 'editListrecipient'));
        $this->assertTrue(method_exists($this->mailjetService, 'getClient'));
    }

    public function testCanUseClient()
    {
        $client = \Mailjet::getClient();
        $this->assertEquals("Mailjet\Client", get_class($client));
    }

    public function testPost()
    {
        $response = $this->mailjetService->post('resource-test-post', [
            'data' => 'test0001',
        ]);

        $this->assertSame([
            'data' => 'test0001',
            'status' => '0001',
        ], $response->getData());
    }

    public function testGet()
    {
        $response = $this->mailjetService->get('resource-test-get', [
            'data' => 'test0002',
        ], []);

        $this->assertSame([
            'data' => 'test0002',
            'status' => '0002',
        ], $response->getData());
    }

    public function testPut()
    {
        $response = $this->mailjetService->put('resource-test-put', [
            'data' => 'test0003',
        ], []);

        $this->assertSame([
            'data' => 'test0003',
            'status' => '0003',
        ], $response->getData());
    }

    public function testDelete()
    {
        $response = $this->mailjetService->delete('resource-test-delete', [
            'data' => 'test0004',
        ], []);

        $this->assertSame([
            'data' => 'test0004',
            'status' => '0004',
        ], $response->getData());
    }

    public function testGetAllLists()
    {
        $response = $this->mailjetService->getAllLists([
            'data' => 'test0005',
        ]);

        $this->assertSame([
            'filters' => [
                'data' => 'test0005',
            ],
            'status' => '0005',
        ], $response->getData());
    }

    public function testCreateList()
    {
        $response = $this->mailjetService->createList([
            'data' => 'test0006'
        ]);

        $this->assertSame([
            'body' => [
                'data' => 'test0006',
            ],
            'status' => '0006',
        ], $response->getData());
    }

    public function testGetListRecipients()
    {
        $response = $this->mailjetService->getListRecipients([
            'data' => 'test0007'
        ]);

        $this->assertSame([
            'filters' => [
                'data' => 'test0007',
            ],
            'status' => '0007',
        ], $response->getData());
    }

    public function testGetSingleContact()
    {
        $response = $this->mailjetService->getSingleContact(123);

        $this->assertSame([
            'id' => 123,
            'status' => '0008',
        ], $response->getData());
    }

    public function testCreateContact()
    {
        $response = $this->mailjetService->createContact([
            'data' => 'test0009'
        ]);

        $this->assertSame([
            'body' => [
                'data' => 'test0009',
            ],
            'status' => '0009',
        ], $response->getData());
    }

    public function testCreateListRecipient()
    {
        $response = $this->mailjetService->createListRecipient([
            'data' => 'test0010'
        ]);

        $this->assertSame([
            'body' => [
                'data' => 'test0010',
            ],
            'status' => '0010',
        ], $response->getData());
    }

    public function testEditListrecipient()
    {
        $response = $this->mailjetService->editListrecipient(123, [
            'data' => 'test0011'
        ]);

        $this->assertSame([
            'id' => 123,
            'body' => [
                'data' => 'test0011',
            ],
            'status' => '0011',
        ], $response->getData());
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
