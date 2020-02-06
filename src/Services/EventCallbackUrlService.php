<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\EventCallbackUrl;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\EventCallbackUrlContract;

/**
 * https://dev.mailjet.com/email-api/v3/eventcallbackurl/
 */
class EventCallbackUrlService implements EventCallbackUrlContract
{
    /**
     * @var MailjetService
     */
    protected $mailjet;
    
    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Retrieve all EventCallbackUrl.
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getAll(): array
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl);
        
        if (! $response->success()) {
            throw new MailjetException(0, 'EventCallbackUrlService:getAll() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Retrieve one EventCallbackUrl.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function get(string $id): array
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl, ['id' => $id]);
        
        if (! $response->success()) {
            throw new MailjetException(0, 'EventCallbackUrlService:get() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Create one EventCallbackUrl.
     *
     * @param EventCallbackUrl $url
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function create(EventCallbackUrl $url): array
    {
        $response = $this->mailjet->post(Resources::$Eventcallbackurl, ['body' => $url->format()]);
        
        if (! $response->success()) {
            throw new MailjetException(0, 'EventCallbackUrlService:create() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update one EventCallbackUrl.
     *
     * @param string           $id
     * @param EventCallbackUrl $url
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function update(string $id, EventCallbackUrl $url): array
    {
        $response = $this->mailjet->put(Resources::$Eventcallbackurl, ['id' => $id, 'body' => $url->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'EventCallbackUrlService:update() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Delete one EventCallbackUrl.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function delete(string $id): array
    {
        $response = $this->mailjet->delete(Resources::$Eventcallbackurl, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'EventCallbackUrlService:delete() failed', $response);
        }

        return $response->getData();
    }
}
