<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

use RuntimeException;

/**
 * https://dev.mailjet.com/email/reference/contacts/bulk-contact-management/
 */
class Contact extends Model
{
    public const ACTION_ADDFORCE = 'addforce';
    public const ACTION_ADDNOFORCE = 'addnoforce';
    public const ACTION_REMOVE = 'remove';
    public const ACTION_UNSUB = 'unsub';

    public const EMAIL_KEY = 'Email';
    public const NAME_KEY = 'Name';
    public const ACTION_KEY = 'Action';
    public const PROPERTIES_KEY = 'Properties';

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $action;

    public function __construct(string $email, array $optionalProperties = [])
    {
        $this->email = $email;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format Contact for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        $result = [
            self::EMAIL_KEY => $this->email,
            self::PROPERTIES_KEY => array_filter($this->optionalProperties)
        ];

        if ($this->action !== null) {
            $result[self::ACTION_KEY] = $this->action;
        }

        return $result;
    }

    /**
     * Correspond to Email in Mailjet request.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set contact email.
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email): Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Correspond to Name in MailJet request.
     */
    public function getName(): ?string
    {
        return $this->optionalProperties[self::NAME_KEY] ?? null;
    }

    /**
     * Set contact name.
     *
     * @param string $name
     *
     * @return Contact
     */
    public function setName(string $name): Contact
    {
        $this->optionalProperties[self::NAME_KEY] = $name;

        return $this;
    }

    /**
     * Action to the contact for Synchronization.
     *
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * Action to the contact for Synchronization.
     *
     * @param string $action (ACTION_* const)
     *
     * @return Contact
     */
    public function setAction($action): Contact
    {
        if (! $this->validateAction($action)) {
            throw new RuntimeException("$action: is not a valid Action.");
        }

        $this->action = $action;

        return $this;
    }

    /**
     * Validate action.
     *
     * @param string $action
     *
     * @return bool
     */
    protected function validateAction(string $action): bool
    {
        $available = [self::ACTION_ADDFORCE, self::ACTION_ADDNOFORCE, self::ACTION_REMOVE, self::ACTION_UNSUB];

        return in_array($action, $available);
    }
}
