<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Contact;
use Mailjet\LaravelMailjet\Model\ContactsList;

interface ContactsListContract
{
    public function create(string $id, Contact $contact, $action = Contact::ACTION_ADDFORCE): array;

    public function update(string $id, Contact $contact, $action = Contact::ACTION_ADDNOFORCE): array;

    public function subscribe(string $id, Contact $contact, bool $force = true): array;

    public function unsubscribe(string $id, Contact $contact): array;

    public function delete(string $id, Contact $contact): array;

    public function updateEmail(string $id, Contact $contact, string $oldEmail): array;

    public function uploadManyContactsList(ContactsList $list): array;
}
