<?php namespace App\Listeners\Logs\CRUD;

use App\Events\Logs\CRUD\ActiveEvent;
use App\Listeners\Logs\LogListener;

class ActiveListener extends LogListener
{

    public function handle(ActiveEvent $event)
    {
        parent::handle($event);
    }

}