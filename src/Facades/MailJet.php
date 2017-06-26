<?php

namespace laravelMailjet\Facades;

use Illuminate\Support\Facades\Facade;

class Mailjet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mailJet';
    }
}
