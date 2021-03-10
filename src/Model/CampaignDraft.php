<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

/**
 * https://dev.mailjet.com/email/reference/campaigns/drafts/
 */
class CampaignDraft extends Model
{
    public const LOCALE_KEY = 'Locale';
    public const SENDER_KEY = 'Sender';
    public const SENDER_EMAIL_KEY = 'SenderEmail';
    public const SUBJECT_KEY = 'Subject';
    public const CONTACT_LIST_ID_KEY = 'ContactsListID';

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $senderEmail;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $contactsListId;

    /**
     * @var array|null
     */
    protected $content;

    /**
     * @var string|null
     */
    protected $id;

    public function __construct(string $locale,
                                string $sender,
                                string $senderEmail,
                                string $subject,
                                string $contactsListId,
                                array $optionalProperties = [])
    {
        $this->locale = $locale;
        $this->sender = $sender;
        $this->senderEmail = $senderEmail;
        $this->subject = $subject;
        $this->contactsListId = $contactsListId;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format CampaignDraft for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        $result = [
            self::LOCALE_KEY => $this->locale,
            self::SENDER_KEY => $this->sender,
            self::SENDER_EMAIL_KEY => $this->senderEmail,
            self::SUBJECT_KEY => $this->subject,
            self::CONTACT_LIST_ID_KEY => $this->contactsListId
        ];

        return array_merge($result, $this->optionalProperties);
    }

    /**
     * Get CampaignDraft content.
     *
     * @return array|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * Set CampaignDraft content.
     *
     * @param $content
     *
     * @return \Mailjet\LaravelMailjet\Model\CampaignDraft
     */
    public function setContent($content): CampaignDraft
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get CampaignDraft id.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set CampaignDraft id.
     *
     * @param string $id
     *
     * @return \Mailjet\LaravelMailjet\Model\CampaignDraft
     */
    public function setId(string $id): CampaignDraft
    {
        $this->id = $id;

        return $this;
    }
}
