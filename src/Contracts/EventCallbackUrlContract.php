<?php

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\EventCallbackUrl;

interface EventCallbackUrlContract
{

    public function getAll();

    public function get($id);

    public function create(EventCallbackUrl $eventCallbackUrl);

    public function update($id, EventCallbackUrl $eventCallbackUrl);

    public function delete($id);
}