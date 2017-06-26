<?php

namespace laravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Client;

class MailJetService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(config('services.mailjet.key'), config('services.mailjet.secret'));
    }

    public function getAllLists($filters)
    {
        $response = $this->client->get(Resources::$Contactslist, ['filters' => $filters]);
        return $response;
    }

    public function createList($body)
    {
        $response = $this->client->post(Resources::$Contactslist, ['body' => $body]);
        return $response;
    }

    public function getListRecipients($filters)
    {
        $response = $this->client->get(Resources::$Listrecipient, ['filters' => $filters]);
        return $response;
    }

    public function getSingleContact($id)
    {
        $response = $this->client->get(Resources::$Contact, ['id' => $id]);
        return $response;
    }

    public function createContact($body)
    {
        $response = $this->client->post(Resources::$Contact, ['body' => $body]);
        return $response;
    }

    public function createListRecipient($body)
    {
        $response = $this->client->post(Resources::$Listrecipient, ['body' => $body]);
        return $response;
    }

    public function editListrecipient($id, $body)
    {
        $response = $this->client->put(Resources::$Listrecipient, ['id'=>$id, 'body' => $body]);
        return $response;
    }

    public function sendMail($subject, $message)
    {
        $body = ['FromEmail' => env('MAILJET_FROMEMAIL'), 'FromName'=> env('MAILJET_FROMNAME'), 'To' => env('MAILJET_TOEMAIL'), 'Subject' => $subject,'Html-part' => $message ];
        $response = $this->client->post(Resources::$Email, ['body'=> $body]);
        return $response;
    }
}
