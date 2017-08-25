<?php

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Campaign;

interface CampaignContract
{

    public function getAllCampaigns(array $filters = null);

    public function findByCampaignId($CampaignId);

    public function findByNewsletterId($NewsletterId);

    public function updateCampaign($CampaignId, Campaign $campaign);
}