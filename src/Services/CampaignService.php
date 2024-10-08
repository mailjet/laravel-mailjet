<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\Campaign;
use Mailjet\LaravelMailjet\Contracts\CampaignContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
 * https://dev.mailjet.com/email-api/v3/campaign/
 */
class CampaignService implements CampaignContract
{
    /**
     * @var MailjetService
     */
    protected MailjetService $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * List campaigns resources available for this apikey
     * @param array|null $filters
     * @return array
     * @throws MailjetException
     */
    public function getAllCampaigns(array $filters = null): array
    {
        $response = $this->mailjet->get(Resources::$Campaign, ['filters' => $filters]);

        if (! $response->success()) {
            throw new MailjetException(0, 'CampaignService:getAllCampaigns() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Access a given campaign resource.
     * @param string $id
     * @return array
     * @throws MailjetException
     */
    public function findByCampaignId(string $id): array
    {
        $response = $this->mailjet->get(Resources::$Campaign, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'CampaignService:findByCampaignId() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Find a given campaign by Newsletter / CampaignDraft id.
     *
     * @param string $id
     *
     * @return array
     * @throws MailjetException
     */
    public function findByNewsletterId(string $id): array
    {
        $response = $this->mailjet->get(Resources::$Campaign, ['mj.nl' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'CampaignService:findByNewsletterId() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific campaign resource with a PUT request.
     * @param string $id
     * @param Campaign $campaign
     * @return array
     * @throws MailjetException
     */
    public function updateCampaign(string $id, Campaign $campaign): array
    {
        $response = $this->mailjet->put(Resources::$Campaign, ['id' => $id, 'body' => $campaign->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'CampaignService:updateCampaign() failed', $response);
        }

        return $response->getData();
    }
}
