<?php namespace App\Listeners\Notifications\Content;

use App\Events\Notifications\Content\NewsAvailableEvent;
use App\Listeners\Notifications\NotificationListener;

class NewsAvailableListener extends NotificationListener
{

    public function handle(NewsAvailableEvent $event)
    {
        parent::handle($event);
    }
}
