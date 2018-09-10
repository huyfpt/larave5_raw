<?php namespace App\Listeners\Logs\CRUD;

use App\Events\Logs\CRUD\DeleteEvent;
use App\Listeners\Logs\LogListener;

class DeleteListener extends LogListener
{

    public function handle(DeleteEvent $event)
    {
        parent::handle($event);
    }
}