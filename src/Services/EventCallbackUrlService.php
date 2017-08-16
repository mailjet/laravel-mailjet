<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Model\EventCallbackUrl;
use Mailjet\LaravelMailjet\Contracts\EventCallbackUrlContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
* https://dev.mailjet.com/email-api/v3/eventcallbackurl/
* Manage EventCallbackUrl
*/
class EventCallbackUrlService implements EventCallbackUrlContract
{

    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    /**
     * @param MailjetClient $mailjet
     */
    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Retrieve all EventCallbackUrl
     * @return array
     */
    public function getAll()
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlService:getAll() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Retrieve one EventCallbackUrl
     * @param string $id
     * @return array
     */
    public function get($id)
    {
        $response = $this->mailjet->get(Resources::$Eventcallbackurl, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlService:get() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Create one EventCallbackUrl
     * @param EventCallbackUrl $eventCallbackUrl
     * @return array
     */
    public function create(EventCallbackUrl $eventCallbackUrl)
    {
        $response = $this->mailjet->post(Resources::$Eventcallbackurl, ['body' => $eventCallbackUrl->format()]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlService:create() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one EventCallbackUrl
     * @param string $id
     * @param EventCallbackUrl $eventCallbackUrl
     * @return array
     */
    public function update($id, EventCallbackUrl $eventCallbackUrl)
    {
        $response = $this->mailjet->put(Resources::$Eventcallbackurl, ['id' => $id, 'body' => $eventCallbackUrl->format()]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlService:update() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Delete one EventCallbackUrl
     * @param string $id
     * @return array
     */
    public function delete($id)
    {
        $response = $this->mailjet->delete(Resources::$Eventcallbackurl, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("EventCallbackUrlService:delete() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  Response $response
     * @param  array $response
     */
     private function throwError($title, Response $response)
     {
         throw new MailjetException(0, $title, $response);
     }
}