<?php

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Contact;
use Mailjet\LaravelMailjet\Model\ContactsList;

interface ContactsListContract
{

    public function create($listId, Contact $contact,
                           $action = Contact::ACTION_ADDFORCE);

    public function update($listId, Contact $contact,
                           $action = Contact::ACTION_ADDNOFORCE);

    public function subscribe($listId, Contact $contact, $force = true);

    public function unsubscribe($listId, Contact $contact);

    public function delete($listId, Contact $contact);

    public function updateEmail($listId, Contact $contact, $oldEmail);

    public function uploadManyContactsList(ContactsList $contactsList);
}