<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\ContactMetadata;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\ContactMetadataContract;

/**
 * https://dev.mailjet.com/email-api/v3/contactmetadata/
 */
class ContactMetadataService implements ContactMetadataContract
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
     * Retrieve all ContactMetadata.
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getAll(): array
    {
        $response = $this->mailjet->get(Resources::$Contactmetadata);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactMetadataService:getAll() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Retrieve one ContactMetadata.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function get(string $id): array
    {
        $response = $this->mailjet->get(Resources::$Contactmetadata, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactMetadataService:get() failed', $response);
        }

        return $response->getData();
    }

    /**
     * create a new fresh ContactMetadata
     *
     * @param ContactMetadata $metadata
     *
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function create(ContactMetadata $metadata): array
    {
        $response = $this->mailjet->post(Resources::$Contactmetadata, ['body' => $metadata->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactMetadataService:create() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update one ContactMetadata
     *
     * @param string          $id
     * @param ContactMetadata $metadata
     *
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function update(string $id, ContactMetadata $metadata): array
    {
        $response = $this->mailjet->put(Resources::$Contactmetadata, ['id' => $id, 'body' => $metadata->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactMetadataService:update() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Delete one ContactMetadata
     *
     * @param string $id
     *
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function delete(string $id): array
    {
        $response = $this->mailjet->delete(Resources::$Contactmetadata, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'ContactMetadataService:delete() failed', $response);
        }

        return $response->getData();
    }
}
