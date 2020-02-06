<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

use RuntimeException;

/**
 * https://dev.mailjet.com/email/reference/webhook/
 */
class EventCallbackUrl implements Requestable
{
    public const EVENT_TYPE_OPEN = 'open';
    public const EVENT_TYPE_CLICK = 'click';
    public const EVENT_TYPE_BOUNCE = 'bounce';
    public const EVENT_TYPE_SPAM = 'spam';
    public const EVENT_TYPE_BLOCKED = 'blocked';
    public const EVENT_TYPE_UNSUB = 'unsub';
    public const EVENT_TYPE_SENT = 'sent';

    public const EVENT_STATUS_DEAD = 'dead';
    public const EVENT_STATUS_ALIVE = 'alive';

    /**
     * @var string|null
     */
    protected $apiKeyId;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var bool
     */
    protected $isBackup;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var bool
     */
    protected $groupEvent;

    public function __construct($url,
                                $type = self::EVENT_TYPE_OPEN,
                                $groupEvent = false,
                                $isBackup = false,
                                $status = self::EVENT_STATUS_ALIVE,
                                $version = 1,
                                $apiKeyId = null
    ) {
        if (! $this->validateType($type)) {
            throw new RuntimeException("$type: is not a valid event type.");
        }

        if (! $this->validateStatus($status)) {
            throw new RuntimeException("$status: is not a valid event status.");
        }

        $this->url = $url;
        $this->type = $type;
        $this->isBackup = $isBackup;
        $this->status = $status;
        $this->version = $version;
        $this->apiKeyId = $apiKeyId;
        $this->groupEvent = $groupEvent;
    }

    /**
     * Format contactList for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        if ($this->groupEvent) {
            // Events are grouped only in API version 2.
            $this->version = 2;
        }

        $result = [
            'Url' => $this->url,
            'EventType' => $this->type,
            'IsBackup' => $this->isBackup,
            'Status' => $this->status,
            'Version' => $this->version,
        ];

        if ($this->apiKeyId) {
            $result['APIKeyID'] = $this->apiKeyId;
        }

        return $result;
    }

    /**
     * Validate event type.
     *
     * @param string $type
     *
     * @return bool
     */
    protected function validateType(string $type): bool
    {
        $available = [
            self::EVENT_TYPE_OPEN,
            self::EVENT_TYPE_CLICK,
            self::EVENT_TYPE_BOUNCE,
            self::EVENT_TYPE_SPAM,
            self::EVENT_TYPE_BLOCKED,
            self::EVENT_TYPE_UNSUB,
            self::EVENT_TYPE_SENT,
        ];

        return in_array($type, $available);
    }

    /**
     * Validate event status.
     *
     * @param string $status
     *
     * @return bool
     */
    protected function validateStatus(string $status): bool
    {
        $available = [self::EVENT_STATUS_ALIVE, self::EVENT_STATUS_DEAD];

        return in_array($status, $available);
    }
}
