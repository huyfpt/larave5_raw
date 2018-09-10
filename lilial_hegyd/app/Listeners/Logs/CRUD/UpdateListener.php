<?php namespace App\Listeners\Logs\CRUD;

use App\Events\Logs\CRUD\UpdateEvent;
use App\Listeners\Logs\LogListener;

class UpdateListener extends LogListener
{

    public function handle(UpdateEvent $event)
    {
        parent::handle($event);
    }
}