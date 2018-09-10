<?php namespace App\Listeners\Notifications\Content;

use App\Events\Notifications\Content\NewCommunicationPlanEvent;
use App\Listeners\Notifications\NotificationListener;

class NewCommunicationPlanListener extends NotificationListener
{

    public function handle(NewCommunicationPlanEvent $event)
    {
        parent::handle($event);
    }
}
