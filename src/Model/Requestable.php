<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

interface Requestable
{
    /**
     * Format MailJet API request.
     *
     * @return array
     */
    public function format(): array;
}
