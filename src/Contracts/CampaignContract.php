<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Campaign;

interface CampaignContract
{
    /**
     * @param array|null $filters
     * @return array
     */
    public function getAllCampaigns(array $filters = null): array;

    /**
     * @param string $id
     * @return array
     */
    public function findByCampaignId(string $id): array;

    /**
     * @param string $id
     * @return array
     */
    public function findByNewsletterId(string $id): array;

    /**
     * @param string $id
     * @param Campaign $campaign
     * @return array
     */
    public function updateCampaign(string $id, Campaign $campaign): array;
}
