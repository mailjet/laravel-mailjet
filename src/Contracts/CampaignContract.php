<?php

namespace Mailjet\LaravelMailjet\Contracts;
use Mailjet\LaravelMailjet\Model\Campaign;

/**
 * Description of CampaignContract
 *
 * @author l.atanasov
 */
interface CampaignContract
{
    public function getAllCampaigns(array $filters = null);
    public function findByCampaignId($CampaignId);
    public function updateCampaign($CampaignId, Campaign $campaign);
}