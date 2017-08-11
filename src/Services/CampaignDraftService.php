<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Model\CampaignDraft;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
 * https://dev.mailjet.com/email-api/v3/campaigndraft/
 * CampaignDraft data. (list,view, create, update, delete,schedule,send ...)
 */
class CampaignDraftService
{
    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * List campaigndraft resources available for this apikey
     * @return array
     */
    public function getAllCampaignDrafts(array $filters = null)
    {
        $response = $this->mailjet->get(Resources::$Campaigndraft,
            ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager :getAllCampaignDrafts() failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Access a given campaigndraft resource
     * @param string $CampaignId
     * @return array
     */
    public function findByCampaignDraftId($CampaignId)
    {
        $response = $this->mailjet->get(Resources::$Campaigndraft,
            ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:findByCampaignDraftId() failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * create a new fresh CampaignDraft
     * @param Campaigndraft $campaignDraft
     */
    public function create(CampaignDraft $campaignDraft)
    {
        $response = $this->mailjet->post(Resources::$Campaigndraft,
            ['body' => $campaignDraft->format()]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:create() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific campaigndraft resource
     * @param int $id
     * @param Campaigndraft $campaignDraft
     */
    public function update($CampaignId, CampaignDraft $campaignDraft)
    {
        $response = $this->mailjet->put(Resources::$Campaigndraft,
            ['id' => $CampaignId, 'body' => $campaignDraft->format()]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:update() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Return the text and html contents of the campaigndraft
     * @param string $id
     * @return array
     */
    public function getDetailContent($id)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftDetailcontent,
            ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:getDetailContent failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Creates the content of a  campaigndraft
     * @param string $id
     * @return array
     */
    public function createDetailContent($id, $contentData)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftDetailcontent,
            ['id' => $id, 'body' => $contentData]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:createDetailContent failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Return the date of the scheduled sending of the campaigndraft
     * @param string Campaign $id
     * @return array
     */
    public function getSchedule($CampaignId)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftSchedule,
            ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:getSchedule failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Schedule when the campaigndraft will be sent
     * @param string Campaign $id
     * @param string Schedule $date
     * @return array
     */
    public function scheduleCampaign($CampaignId, $date)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftSchedule,
            ['id' => $CampaignId, 'body' => $date]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:scheduleCampaign failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Update the date when the campaigndraft will be sent
     * @param string Campaign $id
     * @param string Schedule $date
     * @return array
     */
    public function updateCampaignSchedule($CampaignId, $date)
    {
        $response = $this->mailjet->put(Resources::$CampaigndraftSchedule,
            ['id' => $CampaignId, 'body' => $date]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:updateCampaignSchedule failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Cancel a future sending
     * @param string Campaign $id
     * @return array
     */
    public function removeSchedule($CampaignId)
    {
        $response = $this->mailjet->delete(Resources::$CampaigndraftSchedule,
            ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:removeSchedule failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Send the campaign immediately
     * @param string Campaign $id
     * @return array
     */
    public function sendCampaign($CampaignId)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftSend,
            ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:sendCampaign failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Return the status of a CampaignDraft
     * @param string Campaign $id
     * @return array
     */
    public function getCampaignStatus($CampaignId)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftStatus,
            ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:getCampaignStatus failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * An action to test a CampaignDraft.
     * @param string Campaign $id
     * @param array of  $recipients
     * @return array
     */
    public function testCampaign($CampaignId, $recipients)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftTest,
            ['id' => $CampaignId, 'body' => $recipients]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:getCampaignStatus failed",
                $response);
        }

        return $response->getData();
    }

    private function throwError($title, Response $response)
    {
        throw new MailjetException(0, $title, $response);
    }
}