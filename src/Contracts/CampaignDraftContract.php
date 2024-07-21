<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\CampaignDraft;

interface CampaignDraftContract
{
    /**
     * @param array|null $filters
     * @return array
     */
    public function getAllCampaignDrafts(array $filters = null): array;

    /**
     * @param string $id
     * @return array
     */
    public function findByCampaignDraftId(string $id): array;

    /**
     * @param CampaignDraft $campaignDraft
     * @return array
     */
    public function create(CampaignDraft $campaignDraft): array;

    /**
     * @param string $id
     * @param CampaignDraft $campaignDraft
     * @return array
     */
    public function update(string $id, CampaignDraft $campaignDraft): array;

    /**
     * @param string $id
     * @return array
     */
    public function getDetailContent(string $id): array;

    /**
     * @param string $id
     * @param array $content
     * @return array
     */
    public function createDetailContent(string $id, array $content): array;

    /**
     * @param string $id
     * @return array
     */
    public function getSchedule(string $id): array;

    /**
     * @param string $id
     * @param string $date
     * @return array
     */
    public function scheduleCampaign(string $id, string $date): array;

    /**
     * @param string $id
     * @param string $date
     * @return array
     */
    public function updateCampaignSchedule(string $id, string $date): array;

    /**
     * @param string $id
     * @return array
     */
    public function removeSchedule(string $id): array;

    /**
     * @param string $id
     * @return array
     */
    public function sendCampaign(string $id): array;

    /**
     * @param string $id
     * @param array $recipients
     * @return array
     */
    public function testCampaign(string $id, array $recipients): array;

    /**
     * @param string $id
     * @return array
     */
    public function getCampaignStatus(string $id): array;
}
