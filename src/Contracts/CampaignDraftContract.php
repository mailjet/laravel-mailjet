<?php

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\CampaignDraft;

interface CampaignDraftContract
{

    public function getAllCampaignDrafts(array $filters = null);

    public function findByCampaignDraftId($CampaignId);

    public function create(CampaignDraft $campaignDraft);

    public function update($CampaignId, CampaignDraft $campaignDraft);

    public function getDetailContent($id);

    public function createDetailContent($id, $contentData);

    public function getSchedule($CampaignId);

    public function scheduleCampaign($CampaignId, $date);

    public function updateCampaignSchedule($CampaignId, $date);

    public function removeSchedule($CampaignId);

    public function sendCampaign($CampaignId);

    public function testCampaign($CampaignId, $recipients);

    public function getCampaignStatus($CampaignId);
}