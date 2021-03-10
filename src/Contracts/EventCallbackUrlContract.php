<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\EventCallbackUrl;

interface EventCallbackUrlContract
{
    public function getAll(): array;

    public function get(string $id): array;

    public function create(EventCallbackUrl $url): array;

    public function update(string $id, EventCallbackUrl $url): array;

    public function delete(string $id): array;
}
