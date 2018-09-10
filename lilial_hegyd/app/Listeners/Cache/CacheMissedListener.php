<?php namespace App\Listeners\Cache;


use App\Facades\AppCacheManager;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheMissedListener
{

    public function handle(CacheMissed $event)
    {
        AppCacheManager::settingByKey($event->key, true);
    }
}