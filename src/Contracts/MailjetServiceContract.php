<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\Client;
use Mailjet\Response;

interface MailjetServiceContract
{
    public function post(array $resource, array $args = [], array $options = []): Response;

    public function get(array $resource, array $args = [], array $options = []): Response;

    public function put(array $resource, array $args = [], array $options = []): Response;

    public function delete(array $resource, array $args = [], array $options = []): Response;

    public function getClient(): Client;
}
