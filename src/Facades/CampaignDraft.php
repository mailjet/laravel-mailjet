<?php

namespace Mailjet\LaravelMailjet\Facades;

use Illuminate\Support\Facades\Facade;




class CampaignDraft extends Facade
{
       protected static function getFacadeAccessor()
    {
        return 'CampaignDraft';
    }
}