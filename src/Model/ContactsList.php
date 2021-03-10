<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

use RuntimeException;

/**
 * https://dev.mailjet.com/email/reference/contacts/contact-list/
 */
class ContactsList extends Model
{
    public const ACTION_ADDFORCE = 'addforce';
    public const ACTION_ADDNOFORCE = 'addnoforce';
    public const ACTION_REMOVE = 'remove';
    public const ACTION_UNSUB = 'unsub';

    /**
     * @var string
     */
    protected $listId;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $contacts;

    public function __construct(string $listId, string $action, array $contacts)
    {
        if (! $this->validateAction($action)) {
            throw new RuntimeException("$action: is not a valid Action.");
        }

        $this->listId = $listId;
        $this->action = $action;
        $this->contacts = $contacts;
    }

    /**
     * Format contactList for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        $result = [
            'Action' => $this->action,
        ];

        $result['Contacts'] = array_map(static function (Contact $contact) {
            return $contact->format();
        }, $this->contacts);

        return $result;
    }

    /**
     * Get list id
     */
    public function getListId(): string
    {
        return $this->listId;
    }

    /**
     * Get action.
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Set action.
     *
     * @param string $action
     */
    public function setAction($action): ContactsList
    {
        if (! $this->validateAction($action)) {
            throw new RuntimeException("$action: is not a valid Action.");
        }

        $this->action = $action;

        return $this;
    }

    /**
     * Get contacts.
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * Validate action name.
     *
     * @param string $action
     *
     * @return bool
     */
    protected function validateAction($action): bool
    {
        $actionsAvailable = [self::ACTION_ADDFORCE, self::ACTION_ADDNOFORCE, self::ACTION_REMOVE, self::ACTION_UNSUB];

        return in_array($action, $actionsAvailable);
    }
}
