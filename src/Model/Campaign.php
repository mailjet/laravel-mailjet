<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

/**
 * https://dev.mailjet.com/email/reference/send-emails/
 */
class Campaign extends Model
{
    public const FROM_EMAIL_KEY = 'FromEmail';

    /**
     * @var string
     */
    protected $fromEmail;

    /**
     * @param string $fromEmail
     * @param array  $optionalProperties
     */
    public function __construct(string $fromEmail, array $optionalProperties = [])
    {
        $this->fromEmail = $fromEmail;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format Campaign for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        $result[self::FROM_EMAIL_KEY] = $this->fromEmail;

        return array_merge($result, $this->optionalProperties);
    }
}
