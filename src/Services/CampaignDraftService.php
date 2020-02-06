<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Response;
use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\CampaignDraft;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\CampaignDraftContract;

/**
 * https://dev.mailjet.com/email-api/v3/campaigndraft/
 */
class CampaignDraftService implements CampaignDraftContract
{
    /**
     * @var MailjetService
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * List campaign draft resources available for this apikey.
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getAllCampaignDrafts(array $filters = null): array
    {
        $response = $this->mailjet->get(Resources::$Campaigndraft, ['filters' => $filters]);

        if (! $response->success()) {
            throw new MailjetException(0, 'CampaignDraftService :getAllCampaignDrafts() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Access a given CampaignDraft resource.
     *
     * @param string $id
     *
     * @return array
     */
    public function findByCampaignDraftId(string $id)
    {
        $response = $this->mailjet->get(Resources::$Campaigndraft,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:findByCampaignDraftId() failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * create a new fresh CampaignDraft
     *
     * @param Campaigndraft $campaignDraft
     */
    public function create(CampaignDraft $campaignDraft)
    {
        $response = $this->mailjet->post(Resources::$Campaigndraft,
            ['body' => $campaignDraft->format()]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:create() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific campaigndraft resource
     *
     * @param int           $id
     * @param Campaigndraft $campaignDraft
     */
    public function update($id, CampaignDraft $campaignDraft)
    {
        $response = $this->mailjet->put(Resources::$Campaigndraft,
            ['id' => $id, 'body' => $campaignDraft->format()]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:update() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Return the text and html contents of the campaigndraft
     *
     * @param string $id
     *
     * @return array
     */
    public function getDetailContent(string $id)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftDetailcontent,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:getDetailContent failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Creates the content of a  campaigndraft
     *
     * @param string $id
     *
     * @return array
     */
    public function createDetailContent($id, $contentData)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftDetailcontent,
            ['id' => $id, 'body' => $contentData]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:createDetailContent failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Return the date of the scheduled sending of the campaigndraft
     *
     * @param string Campaign $id
     *
     * @return array
     */
    public function getSchedule(string $id)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftSchedule,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:getSchedule failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Schedule when the campaigndraft will be sent
     *
     * @param string $id
     * @param string $date (RFC3339 format "Y-m-d\TH:i:sP")
     *
     * @return array
     */
    public function scheduleCampaign(string $id, string $date)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftSchedule,
            ['id' => $id, 'body' => $date]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:scheduleCampaign failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Update the date when the campaigndraft will be sent
     *
     * @param string Campaign $id
     * @param string Schedule $date
     *
     * @return array
     */
    public function updateCampaignSchedule($id, $date)
    {
        $response = $this->mailjet->put(Resources::$CampaigndraftSchedule,
            ['id' => $id, 'body' => $date]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:updateCampaignSchedule failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Cancel a future sending
     *
     * @param string Campaign $id
     *
     * @return array
     */
    public function removeSchedule(string $id)
    {
        $response = $this->mailjet->delete(Resources::$CampaigndraftSchedule,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:removeSchedule failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Send the campaign immediately
     *
     * @param string Campaign $id
     *
     * @return array
     */
    public function sendCampaign(string $id)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftSend,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:sendCampaign failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * Return the status of a CampaignDraft
     *
     * @param string Campaign $id
     *
     * @return array
     */
    public function getCampaignStatus(string $id)
    {
        $response = $this->mailjet->get(Resources::$CampaigndraftStatus,
            ['id' => $id]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:getCampaignStatus failed',
                $response);
        }

        return $response->getData();
    }

    /**
     * An action to test a CampaignDraft.
     *
     * @param string Campaign $id
     * @param array of  $recipients
     *
     * @return array
     */
    public function testCampaign($id, $recipients)
    {
        $response = $this->mailjet->post(Resources::$CampaigndraftTest,
            ['id' => $id, 'body' => $recipients]);
        if (! $response->success()) {
            $this->throwError('CampaignDraftService:testCampaign failed',
                $response);
        }

        return $response->getData();
    }

    private function throwError($title, Response $response)
    {
        throw new MailjetException(0, $title, $response);
    }
}
