<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\Client;
use Mailjet\Response;

interface MailjetServiceContract
{
    /**
     * @param array $resource
     * @param array $args
     * @param array $options
     * @return Response
     */
    public function post(array $resource, array $args = [], array $options = []): Response;

    /**
     * @param array $resource
     * @param array $args
     * @param array $options
     * @return Response
     */
    public function get(array $resource, array $args = [], array $options = []): Response;

    /**
     * @param array $resource
     * @param array $args
     * @param array $options
     * @return Response
     */
    public function put(array $resource, array $args = [], array $options = []): Response;

    /**
     * @param array $resource
     * @param array $args
     * @param array $options
     * @return Response
     */
    public function delete(array $resource, array $args = [], array $options = []): Response;

    /**
     * @return Client
     */
    public function getClient(): Client;
}
