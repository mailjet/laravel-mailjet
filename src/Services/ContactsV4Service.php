<?php

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\LaravelMailjet\Contracts\ContactsV4Contract;
use \Mailjet\Resources;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
* https://dev.mailjet.com/email/guides/contact-management/#gdpr-delete-contacts
*/
class ContactsV4Service implements ContactsV4Contract
{
    /**
     * Mailjet client
     * @var MailjetService
     */
    protected $mailjet;

    /**
     * @param MailjetService $mailjet
     */
    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Delete a Contact
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $response = $this->mailjet->delete(['contacts', ''], ['id' => $id]);

        if (!$response->success()) {
            throw new MailjetException(0, "ContactsV4Service:delete() failed", $response);
        }

        return 200 === $response->getStatus();
    }
}