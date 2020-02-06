<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\CampaignDraft;

interface CampaignDraftContract
{
    public function getAllCampaignDrafts(array $filters = null);

    public function findByCampaignDraftId(string $id);

    public function create(CampaignDraft $campaignDraft);

    public function update(string $id, CampaignDraft $campaignDraft);

    public function getDetailContent(string $id);

    public function createDetailContent(string $id, array $content);

    public function getSchedule(string $id);

    public function scheduleCampaign(string $id, string $date);

    public function updateCampaignSchedule(string $id, string $date);

    public function removeSchedule(string $id);

    public function sendCampaign(string $id);

    public function testCampaign(string $id, array $recipients);

    public function getCampaignStatus(string $id);
}
