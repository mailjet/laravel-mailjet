<?php

namespace Mailjet\LaravelMailjet\Model;

/**
 * https://dev.mailjet.com/email-api/v3/campaigndraft/
 */
class CampaignDraft {

    const LOCALE_KEY = 'Locale';
    const SENDER_KEY = 'Sender';
    const SENDEREMAIL_KEY = 'SenderEmail';
    const SUBJECT_KEY = 'Subject';
    const CONTACTLISTID_KEY = 'ContactsListID';

    //Mandatory properties (must be set through constructor)
    protected $locale;
    protected $sender;
    protected $senderEmail;
    protected $subject;
    protected $contactsListID;
    //Optional properties (array)
    protected $optionalProperties = null;
    //content
    protected $content = null;
    //id
    protected $id = null;

    /**
     * @param $Locale
     * @param $Sender
     * @param $SenderEmail
     * @param $Subject
     * @param $ContactsListID
     * @param optionalProperties
     */
    public function __construct($locale, $sender, $senderEmail, $subject, $contactsListID, $optionalProperties = null) {
        $this->locale = $locale;
        $this->sender = $sender;
        $this->senderEmail = $senderEmail;
        $this->subject = $subject;
        $this->contactsListID = $contactsListID;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format CampaignDraft for MailJet API request
     * @return array
     */
    public function format() {

        /*         * Add the mandatary props* */
        if (!is_null($this->locale)) {
            $result[self::LOCALE_KEY] = $this->locale;
        }

        if (!is_null($this->sender)) {
            $result[self::SENDER_KEY] = $this->sender;
        }

        if (!is_null($this->senderEmail)) {
            $result[self::SENDEREMAIL_KEY] = $this->senderEmail;
        }
        if (!is_null($this->subject)) {
            $result[self::SUBJECT_KEY] = $this->subject;
        }
        if (!is_null($this->contactsListID)) {
            $result[self::CONTACTLISTID_KEY] = $this->contactsListID;
        }
        /*         * Add the optional props if any* */
        if (!is_null($this->optionalProperties)) {
            $result = array_merge($result, $this->optionalProperties);
        }


        return $result;
    }

    /**
     * Correspond to properties in MailJet request
     * Array ['PropertyName' => value, ...]
     */
    public function getOptionalProperties() {
        return $this->optionalProperties;
    }

    /**
     * Set array of CampaignDraft properties
     * @param array $property
     * @return Properties
     */
    public function setOptionalProperties(array $properties) {
        $this->optionalProperties = $properties;
        return $this->optionalProperties;
    }

    /**
     * Add a new $property to CampaignDraft
     * @param array $property
     * @return Properties
     */
    public function addOptionalProperty(array $property) {
        $this->optionalProperties[] = $property;
        return $this->optionalProperties;
    }

    /**
     * Remove a $property from CampaignDraft
     * @param array $property
     * @return Properties
     */
    public function removeOptionalProperty(array $property) {
        foreach (array_keys($this->optionalProperties, $property) as $key) {
            unset($this->optionalProperties[$key]);
        }
        return $this->optionalProperties;
    }

    /**
     * Get  CampaignDraft content
     * @return $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * Get  CampaignDraft content
     * @return $content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Get  CampaignDraft id
     * @return $content
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set  CampaignDraft Id
     * @return $content
     */
    public function setId($id) {
        $this->id = $id;
    }

}
