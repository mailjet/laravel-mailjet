<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Model\Campaign;
use Mailjet\LaravelMailjet\Contracts\CampaignContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
 * https://dev.mailjet.com/email-api/v3/campaign/
 * list/view/update
 */
class CampaignService implements CampaignContract {

    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet) {
        $this->mailjet = $mailjet;
    }

    /**
     * List campaigns resources available for this apikey
     * @return array
     */
    public function getAllCampaigns(array $filters = null) {
        $response = $this->mailjet->get(Resources::$Campaign, ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("CampaignService:getAllCampaigns() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Access a given campaign resource
     * @param string $CampaignId
     * @return array
     */
    public function findByCampaignId($CampaignId) {
        $response = $this->mailjet->get(Resources::$Campaign, ['id' => $CampaignId]);
        if (!$response->success()) {
            $this->throwError("CampaignService:findByCampaignId() failed", $response);
        }

        return $response->getData();
    }

     /**
     * Find a given campaign by Newsletter/campaigndraftId
     * @param string $NewsletterId
     * @return array
     */
    public function findByNewsletterId($NewsletterId) {
        $response = $this->mailjet->get(Resources::$Campaign, ['mj.nl' => $NewsletterId]);
        if (!$response->success()) {
            $this->throwError("CampaignService:findByNewsletterId() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific campaign resource with a PUT request, providing the campaign's ID value
     * @param string $id
     * @return array
     */
    public function updateCampaign($CampaignId, Campaign $campaign) {
        $response = $this->mailjet->put(Resources::$Campaign, ['id' => $CampaignId, 'body' => $campaign->format()]);
        if (!$response->success()) {
            $this->throwError("CampaignService:updateCampaign() failed", $response);
        }

        return $response->getData();
    }

    private function throwError($title, Response $response) {
        throw new MailjetException(0, $title, $response);
    }

}
