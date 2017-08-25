<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Model\ContactMetadata;
use Mailjet\LaravelMailjet\Contracts\ContactMetadataContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
* https://dev.mailjet.com/email-api/v3/contactmetadata/
* manage ContactsMetadata (create, update, delete, ...)
*
*/
class ContactMetadataService implements ContactMetadataContract
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
     * Retrieve all ContactMetadata
     * @return array
     */
    public function getAll()
    {
        $response = $this->mailjet->get(Resources::$Contactmetadata);
        if (!$response->success()) {
            $this->throwError("ContactMetadataService:getAll() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Retrieve one ContactMetadata
     * @param string $id
     * @return array
     */
    public function get($id)
    {
        $response = $this->mailjet->get(Resources::$Contactmetadata, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("ContactMetadataService:get() failed", $response);
        }

        return $response->getData();
    }

    /**
     * create a new fresh ContactMetadata
     * @param ContactMetadata $contactMetadata
     */
    public function create(ContactMetadata $contactMetadata)
    {
        $response = $this->mailjet->post(Resources::$Contactmetadata, ['body' => $contactMetadata->format()]);
        if (!$response->success()) {
            $this->throwError("ContactMetadataService:create() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one ContactMetadata
     * @param int $id
     * @param ContactMetadata $contactMetadata
     */
    public function update($id, ContactMetadata $contactMetadata)
    {
        $response = $this->mailjet->put(Resources::$Contactmetadata, ['id' => $id,'body' => $contactMetadata->format()]);
        if (!$response->success()) {
            $this->throwError("ContactMetadataService:update() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Delete one ContactMetadata
     * @param int $id
     */
    public function delete($id)
    {
        $response = $this->mailjet->delete(Resources::$Contactmetadata, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("ContactMetadataService:delete() failed", $response);
        }

        return $response->getData();
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
