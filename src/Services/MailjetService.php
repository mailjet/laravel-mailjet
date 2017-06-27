<?php

namespace MoltenCore\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Client;

class MailjetService
{
    /**
     * Mailjet Client
     * @var \Mailjet\Client
     */
    private $client;

    /**
     * Instanciate the client whit the api key and api secret given in the configuration
     */
    public function __construct()
    {
        $this->client = new Client(config('services.mailjet.key'), config('services.mailjet.secret'));
    }

    /**
     * Get all list on your mailjet account
     * @param  array $filters Filters that will be use to filter the request. See mailjet API documentation for all filters available
     * @return array
     */
    public function getAllLists($filters)
    {
        $response = $this->client->get(Resources::$Contactslist, ['filters' => $filters]);
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
        return $response;
    }

    /**
     * Send a mial via tyhe mailjet API. It use the configuration given in the .env file
     * @param  string $subject subject of the mail
     * @param  string $message Message of the mail (could be html or text)
     * @return array
     */
    public function sendMail($subject, $message)
    {
        $body = ['FromEmail' => env('MAILJET_FROMEMAIL'), 'FromName'=> env('MAILJET_FROMNAME'), 'To' => env('MAILJET_TOEMAIL'), 'Subject' => $subject,'Html-part' => $message ];
        $response = $this->client->post(Resources::$Email, ['body'=> $body]);
        return $response;
    }
}
