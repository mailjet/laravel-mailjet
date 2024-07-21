<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\ContactMetadata;

interface ContactMetadataContract
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param string $id
     * @return array
     */
    public function get(string $id): array;

    /**
     * @param ContactMetadata $metadata
     * @return array
     */
    public function create(ContactMetadata $metadata): array;

    /**
     * @param string $id
     * @param ContactMetadata $metadata
     * @return array
     */
    public function update(string $id, ContactMetadata $metadata): array;

    /**
     * @param string $id
     * @return array
     */
    public function delete(string $id): array;
}
