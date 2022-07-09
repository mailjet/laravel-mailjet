<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Response;
use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\Contact;
use Mailjet\LaravelMailjet\Model\ContactsList;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\ContactsListContract;

/**
 * https://dev.mailjet.com/email-api/v3/contactslist-managecontact/
 */
class ContactsListService implements ContactsListContract
{
    /**
     * @var int
     */
    public const CONTACT_BATCH_SIZE = 1000;

    /**
     * @var MailjetService
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * Create a new fresh Contact to listId.
     *
     * @param string  $id
     * @param Contact $contact
     * @param string  $action
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function create(string $id, Contact $contact, $action = Contact::ACTION_ADDFORCE): array
    {
        $contact->setAction($action);

        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:create() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update a Contact to listId.
     *
     * @param string  $id
     * @param Contact $contact
     * @param string  $action
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function update(string $id, Contact $contact, $action = Contact::ACTION_ADDNOFORCE): array
    {
        $contact->setAction($action);

        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:update() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Re/subscribe a Contact to listId.
     *
     * @param string  $id
     * @param Contact $contact
     * @param bool    $force
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function subscribe(string $id, Contact $contact, bool $force = true): array
    {
        $contact->setAction($force ? Contact::ACTION_ADDFORCE : Contact::ACTION_ADDNOFORCE);

        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:subscribe() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Unsubscribe a Contact from listId.
     *
     * @param string  $id
     * @param Contact $contact
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function unsubscribe(string $id, Contact $contact): array
    {
        $contact->setAction(Contact::ACTION_UNSUB);

        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:unsubscribe() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Delete a Contact from listId
     *
     * @param string  $id
     * @param Contact $contact
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function delete(string $id, Contact $contact): array
    {
        $contact->setAction(Contact::ACTION_REMOVE);

        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:delete() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Change email a Contact.
     *
     * @param string  $id
     * @param Contact $contact
     * @param string  $oldEmail
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function updateEmail(string $id, Contact $contact, string $oldEmail): array
    {
        $response = $this->mailjet->get(Resources::$Contactdata, ['id' => $oldEmail]);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:changeEmail() failed', $response);
        }

        $oldContactData = $response->getData();

        if (isset($oldContactData[0])) {
            $contact->setOptionalProperties($oldContactData[0]['Data']);
        }

        $contact->setAction(Contact::ACTION_ADDFORCE);
        $response = $this->_exec($id, $contact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:changeEmail() failed', $response);
        }

        $oldContact = new Contact($oldEmail);
        $oldContact->setAction(Contact::ACTION_REMOVE);
        $response = $this->_exec($id, $oldContact);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactsListService:changeEmail() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Import many contacts to a list.
     * https://dev.mailjet.com/email-api/v3/contactslist-managemanycontacts/
     *
     * @param ContactsList $list
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function uploadManyContactsList(ContactsList $list): array
    {
        $batchResults = [];
        $contactChunks = array_chunk($list->getContacts(), self::CONTACT_BATCH_SIZE);

        foreach ($contactChunks as $contactChunk) {
            $subContactsList = new ContactsList($list->getListId(), $list->getAction(), $contactChunk);
            $currentBatch = $this->mailjet->post(Resources::$ContactslistManagemanycontacts,
                ['id' => $subContactsList->getListId(), 'body' => $subContactsList->format()]
            );

            if ($currentBatch->success()) {
                $batchResults[] = $currentBatch->getData()[0];
            } else {
                throw new MailjetException(0, 'ContactsListService:manageManyContactsList() failed', $currentBatch);
            }
        }

        return $batchResults;
    }

    /**
     * An action for adding a contact to a contact list. Only POST is supported.
     * The API will internally create the new contact if it does not exist,
     * add or update the name and properties.
     * The properties have to be defined before they can be used.
     * The API then adds the contact to the contact list with active=true
     * and unsub=specified value if it is not already in the list,
     * or updates the entry with these values.
     * On success, the API returns a packet with the same format
     * but with all properties available for that contact.
     *
     * @param string  $id
     * @param Contact $contact
     *
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    private function _exec(string $id, Contact $contact): Response
    {
        return $this->mailjet->post(Resources::$ContactslistManagecontact,
            ['id' => $id, 'body' => $contact->format()]
        );
    }
}
