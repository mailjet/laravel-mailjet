<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Facades;

use Illuminate\Support\Facades\Facade;

class Mailjet extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Mailjet';
    }
}
