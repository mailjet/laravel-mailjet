<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use \Mailjet\Client;
use Mailjet\LaravelMailjet\Contracts\MailjetServiceContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

class MailjetService implements MailjetServiceContract
{
    /**
     * Mailjet Client
     * @var \Mailjet\Client
     */
    private $client;

    /**
     * Instanciate the client whit the api key and api secret given in the configuration
     */
    public function __construct($key, $secret, $call = true, array $settings = [])
    {
        $this->client = new Client($key, $secret, $call, $settings);
    }

    /**
     * Trigger a POST request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function post($resource, array $args = [], array $options = [])
    {
        $response = $this->client->post($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:post() failed", $response);
        }
        return $response;
    }

    /**
     * Trigger a GET request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function get($resource, array $args = [], array $options = [])
    {
        $response = $this->client->get($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:get() failed", $response);
        }
        return $response;
    }

    /**
     * Trigger a PUT request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function put($resource, array $args = [], array $options = [])
    {
        $response = $this->client->put($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:put() failed", $response);
        }
        return $response;
    }

    /**
     * Trigger a DELETE request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function delete($resource, array $args = [], array $options = [])
    {
        $response = $this->client->delete($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:delete() failed", $response);
        }
        return $response;
    }



    /**TODO exclude HIGH Level API methods into managers**/
    /**
     * Get all list on your mailjet account
     * @param  array $filters Filters that will be use to filter the request. See mailjet API documentation for all filters available
     * @return array
     */
    public function getAllLists($filters)
    {
        $response = $this->client->get(Resources::$Contactslist, ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("MailjetService:getAllLists() failed", $response);
        }
        return $response;
    }

    /**
     * Create a new list
     * @param  array $body array containing the list informations. the 'Name' parameter is mandatory.See mailjet API documentation for all parameters available
     * @return array
     */
    public function createList($body)
    {
        $response = $this->client->post(Resources::$Contactslist, ['body' => $body]);
        if (!$response->success()) {
            $this->throwError("MailjetService:createList() failed", $response);
        }
        return $response;
    }

    /**
     * Get all list recipient on your mailjet account
     * @param  array $filters Filters that will be use to filter the request. See mailjet API documentation for all filters available
     * @return array
     */
    public function getListRecipients($filters)
    {
        $response = $this->client->get(Resources::$Listrecipient, ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("MailjetService:getListRecipients() failed", $response);
        }
        return $response;
    }

    /**
     * Get single contact informations.
     * @param  int $id ID of the contact
     * @return array
     */
    public function getSingleContact($id)
    {
        $response = $this->client->get(Resources::$Contact, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("MailjetService:getSingleContact() failed", $response);
        }
        return $response;
    }

    /**
     * create a contact
     * @param  array $body array containing the list informations. the 'Email' parameter is mandatory.See mailjet API documentation for all parameters available
     * @return array
     */
    public function createContact($body)
    {
        $response = $this->client->post(Resources::$Contact, ['body' => $body]);
        if (!$response->success()) {
            $this->throwError("MailjetService:createContact() failed", $response);
        }
        return $response;
    }

    /**
     * create a listrecipient (relationship between contact and list)
     * @param  array $body array containing the list informations. the 'ContactID' and 'ListID' parameters are mandatory.See mailjet API documentation for all parameters available
     * @return array
     */
    public function createListRecipient($body)
    {
        $response = $this->client->post(Resources::$Listrecipient, ['body' => $body]);
        if (!$response->success()) {
            $this->throwError("MailjetService:createListRecipient() failed", $response);
        }
        return $response;
    }

    /**
     * edit a list recipient
     * @param  int $id   id of the list recipient
     * @param  array $body array containing the list informations. the 'ContactID' and 'ListID' parameters are mandatory.See mailjet API documentation for all parameters available
     * @return array
     */
    public function editListrecipient($id, $body)
    {
        $response = $this->client->put(Resources::$Listrecipient, ['id'=>$id, 'body' => $body]);
        if (!$response->success()) {
            $this->throwError("MailjetService:editListrecipient() failed", $response);
        }
        return $response;
    }

    /**
     * Retrieve Mailjet\Client
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Helper to throw error
     * @param  string $title
     * @param  Response $response
     */
     private function throwError($title, Response $response)
     {
         throw new MailjetException(0, $title, $response);
     }
}
