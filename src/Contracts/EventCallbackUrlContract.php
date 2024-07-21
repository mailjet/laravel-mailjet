<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\EventCallbackUrl;

interface EventCallbackUrlContract
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
     * @param EventCallbackUrl $url
     * @return array
     */
    public function create(EventCallbackUrl $url): array;

    /**
     * @param string $id
     * @param EventCallbackUrl $url
     * @return array
     */
    public function update(string $id, EventCallbackUrl $url): array;

    /**
     * @param string $id
     * @return array
     */
    public function delete(string $id): array;
}
