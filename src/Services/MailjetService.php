<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Client;
use Mailjet\Response;
use Mailjet\Resources;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\MailjetServiceContract;

class MailjetService implements MailjetServiceContract
{
    /**
     * @var \Mailjet\Client
     */
    private $client;

    public function __construct(string $key, string $secret, $call = true, array $settings = [])
    {
        $this->client = new Client($key, $secret, $call, $settings);
    }

    /**
     * Trigger a POST request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function post(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->post($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:post() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a GET request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function get(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->get($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:get() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a PUT request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function put(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->put($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:put() failed', $response);
        }

        return $response;
    }

    /**
     * Trigger a DELETE request.
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function delete(array $resource, array $args = [], array $options = []): Response
    {
        $response = $this->client->delete($resource, $args, $options);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:delete() failed', $response);
        }

        return $response;
    }

    /**
     * Get all list on your Mailjet account.
     * TODO: Exclude HIGH Level API methods into managers.
     *
     * @param array $filters Filters that will be use to filter the request
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getAllLists(array $filters = null): Response
    {
        $response = $this->client->get(Resources::$Contactslist, ['filters' => $filters]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:getAllLists() failed', $response);
        }

        return $response;
    }

    /**
     * Create a new list.
     *
     * @param array $body Information list - the 'Name' field is mandatory.
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function createList(array $body): Response
    {
        $response = $this->client->post(Resources::$Contactslist, ['body' => $body]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:createList() failed', $response);
        }

        return $response;
    }

    /**
     * Get all list recipient on your Mailjet account.
     *
     * @param array $filters Filters that will be use to filter the request.
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getListRecipients(array $filters = null): Response
    {
        $response = $this->client->get(Resources::$Listrecipient, ['filters' => $filters]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:getListRecipients() failed', $response);
        }

        return $response;
    }

    /**
     * Get single contact information.
     *
     * @param string $id
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getSingleContact(string $id): Response
    {
        $response = $this->client->get(Resources::$Contact, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:getSingleContact() failed', $response);
        }

        return $response;
    }

    /**
     * Create a contact.
     *
     * @param array $body Information list - the 'Email' field is mandatory.
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function createContact(array $body): Response
    {
        $response = $this->client->post(Resources::$Contact, ['body' => $body]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:createContact() failed', $response);
        }

        return $response;
    }

    /**
     * Create a list recipient (relationship between contact and list).
     *
     * @param array $body Information list - the 'ContactID' and 'ListID' parameters are mandatory.
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function createListRecipient(array $body): Response
    {
        $response = $this->client->post(Resources::$Listrecipient, ['body' => $body]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:createListRecipient() failed', $response);
        }

        return $response;
    }

    /**
     * Edit a list recipient.
     *
     * @param string $id
     * @param array  $body Information list - the 'ContactID' and 'ListID' parameters are mandatory.
     *
     * @return \Mailjet\Response
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function editListRecipient(string $id, array $body): Response
    {
        $response = $this->client->put(Resources::$Listrecipient, ['id' => $id, 'body' => $body]);

        if (! $response->success()) {
            throw new MailjetException(0, 'MailjetService:editListrecipient() failed', $response);
        }

        return $response;
    }

    /**
     * Retrieve Mailjet client.
     *
     * @return \Mailjet\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
