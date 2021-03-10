<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\ContactMetadata;

interface ContactMetadataContract
{
    public function getAll();

    public function get(string $id);

    public function create(ContactMetadata $metadata);

    public function update(string $id, ContactMetadata $metadata);

    public function delete(string $id);
}
