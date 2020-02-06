<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Campaign;

interface CampaignContract
{
    public function getAllCampaigns(array $filters = null);

    public function findByCampaignId(string $id);

    public function findByNewsletterId(string $id);

    public function updateCampaign(string $id, Campaign $campaign);
}
