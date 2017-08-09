<?php

namespace Mailjet\MailjetBundle\Model;

/**
* https://dev.mailjet.com/email-api/v3/contactslist-managecontact/
* Only email is required
*/
class Contact
{
    const ACTION_ADDFORCE = 'addforce'; # adds the contact and resets the unsub status to false
    const ACTION_ADDNOFORCE = 'addnoforce'; # adds the contact and does not change the subscription status of the contact
    const ACTION_REMOVE = 'remove'; # removes the contact from the list
    const ACTION_UNSUB = 'unsub'; # unsubscribes a contact from the list

    const EMAIL_KEY = 'Email';
    const NAME_KEY = 'Name';
    const ACTION_KEY = 'Action';
    const PROPERTIES_KEY = 'Properties';

    protected $email;
    protected $name;
    protected $properties;
    protected $action;

    public function __construct($email, $name = null, array $properties = [])
    {
        $this->email = $email;
        $this->name = $name;
        $this->properties = $properties;
    }

    /**
     * Formate contact for MailJet API request
     * @return array
     */
    public function format()
    {
        $result = [
            self::EMAIL_KEY => $this->email,
        ];

        if (!is_null($this->name)) {
            $result[self::NAME_KEY] = $this->name;
        }

        if (!is_null($this->action)) {
            $result[self::ACTION_KEY] = $this->action;
        }

        if (!is_null($this->properties)) {
            #$result[self::PROPERTIES_KEY] = $this->removeNullProperties($this->properties);
            $result[self::PROPERTIES_KEY] = $this->properties;
        }

        return $result;
    }

    /**
     * Correspond to Email in Mailjet request
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contact email
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Correspond to Name in MailJet request
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set contact name
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Correspond to Properties in MailJet request
     * Array ['property' => value, ...]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set array of Contact properties
     * @param array $properties
     * @return Contact
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * Action to the contact for Synchronization
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Action to the contact for Synchronization
     * @param string $action ACTION_*
     * @return Contact
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Clean null properties to avoid conflict with API
     * @param  array  $properties
     * @return array
     */
    protected function removeNullProperties(array $properties)
    {
        return array_filter($properties);
    }
}
