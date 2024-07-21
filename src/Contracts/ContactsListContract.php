<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Contact;
use Mailjet\LaravelMailjet\Model\ContactsList;

interface ContactsListContract
{
    /**
     * @param string $id
     * @param Contact $contact
     * @param string $action
     * @return array
     */
    public function create(string $id, Contact $contact, string $action = Contact::ACTION_ADDFORCE): array;

    /**
     * @param string $id
     * @param Contact $contact
     * @param string $action
     * @return array
     */
    public function update(string $id, Contact $contact, string $action = Contact::ACTION_ADDNOFORCE): array;

    /**
     * @param string $id
     * @param Contact $contact
     * @param bool $force
     * @return array
     */
    public function subscribe(string $id, Contact $contact, bool $force = true): array;

    /**
     * @param string $id
     * @param Contact $contact
     * @return array
     */
    public function unsubscribe(string $id, Contact $contact): array;

    /**
     * @param string $id
     * @param Contact $contact
     * @return array
     */
    public function delete(string $id, Contact $contact): array;

    /**
     * @param string $id
     * @param Contact $contact
     * @param string $oldEmail
     * @return array
     */
    public function updateEmail(string $id, Contact $contact, string $oldEmail): array;

    /**
     * @param ContactsList $list
     * @return array
     */
    public function uploadManyContactsList(ContactsList $list): array;
}
