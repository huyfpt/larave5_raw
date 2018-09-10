<?php namespace App\Listeners\Logs\CRUD;

use App\Events\Logs\CRUD\CreateEvent;
use App\Listeners\Logs\LogListener;

class CreateListener extends LogListener
{

    public function handle(CreateEvent $event)
    {
        parent::handle($event);
    }

}