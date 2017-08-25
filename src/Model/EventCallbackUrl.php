<?php

namespace Mailjet\LaravelMailjet\Model;

/**
* https://dev.mailjet.com/email-api/v3/eventcallbackurl/
* Model for EventCallbackUrl
*/
class EventCallbackUrl
{
    const EVENT_TYPE_OPEN = 'open';
    const EVENT_TYPE_CLICK = 'click';
    const EVENT_TYPE_BOUNCE = 'bounce';
    const EVENT_TYPE_SPAM = 'spam';
    const EVENT_TYPE_BLOCKED = 'blocked';
    const EVENT_TYPE_UNSUB = 'unsub';
    const EVENT_TYPE_SENT = 'sent';


    const EVENT_STATUS_DEAD = 'dead';
    const EVENT_STATUS_ALIVE = 'alive';

    protected $apikeyId;
    protected $url;
    protected $eventType;
    protected $isBackup;
    protected $status;
    // seems to be a problem between API and UI for Mailjet EventCallbackUrl
    // In the UI when I check the groupEvent checkbox the version=2 when I unchecked
    // version=1...
    // And no properties groupEvent in the API reference and here is the description
    // for version property: Event API version for which this URL is valid.
    protected $version;
    protected $groupEvent;



    /**
     * @param string $apikeyId
     * @param string $url
     * @param string $eventType
     * @param bool   $isBackup
     * @param string $status
     * @param int    $version
     * @param bool   $groupEvent
     */
    public function __construct($url, $eventType = self::EVENT_TYPE_OPEN, $groupEvent = false,
                                $isBackup = false, $status = self::EVENT_STATUS_ALIVE,
                                $version = 1, $apikeyId = null
    ) {
        $this->url = $url;
        $this->eventType = $eventType;
        $this->isBackup = $isBackup;
        $this->status = $status;
        $this->version = $version;
        $this->apikeyId = $apikeyId;
        $this->groupEvent = $groupEvent;
    }

    /**
     * Formate contactList for MailJet API request
     * @return array
     */
    public function format()
    {
        if ($this->groupEvent) {
            // ugly fix for misunderstanding of this...
            $this->version = 2;
        }

        $result = [
            'Url' => $this->url,
            'EventType' => $this->eventType,
            'IsBackup'  => $this->isBackup,
            'Status'    => $this->status,
            'Version'   => $this->version
        ];

        if($this->apikeyId){
            $result['APIKeyID'] = $this->apikeyId;
        }

        return $result;
    }
}
