<?php namespace App\Listeners\Logs\Generic;

use App\Events\Logs\Generic\GenericEvent;
use App\Listeners\Logs\LogListener;

class GenericEventListener extends LogListener
{
    public function handle(GenericEvent $event)
    {
        parent::handle($event);
    }
}