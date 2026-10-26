<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Tests\Services;

use Mailjet\LaravelMailjet\Services\MailjetService;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * The Mailjet API is HTTPS-only: the package must never build a plain HTTP API URL.
 *
 * Runs in separate processes so the real Mailjet\Client is not loaded into the process
 * used by tests that overload it with Mockery.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class MailjetServiceHttpsTest extends TestCase
{
    private static function apiUrl(MailjetService $service): string
    {
        $method = new ReflectionMethod($service->getClient(), 'getApiUrl');
        $method->setAccessible(true);

        return $method->invoke($service->getClient());
    }

    public function testDefaultsToHttps(): void
    {
        $service = new MailjetService('key', 'secret', false);

        $this->assertStringStartsWith('https://api.mailjet.com/', self::apiUrl($service));
    }

    public function testIgnoresInsecureSetting(): void
    {
        $service = new MailjetService('key', 'secret', false, ['secured' => false, 'version' => 'v3']);

        $this->assertSame('https://api.mailjet.com/v3/', self::apiUrl($service));
    }

    /**
     * @dataProvider urlProvider
     */
    public function testStripsSchemeFromUrl(string $url): void
    {
        $service = new MailjetService('key', 'secret', false, ['url' => $url, 'version' => 'v3.1']);

        $this->assertSame('https://api.mailjet.com/v3.1/', self::apiUrl($service));
    }

    public function urlProvider(): array
    {
        return [
            'bare host' => ['api.mailjet.com'],
            'https' => ['https://api.mailjet.com'],
            'http' => ['http://api.mailjet.com'],
        ];
    }
}
