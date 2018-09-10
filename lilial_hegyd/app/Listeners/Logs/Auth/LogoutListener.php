<?php namespace App\Listeners\Logs\Auth;

use App\Events\Logs\Auth\LogoutEvent;
use App\Listeners\Logs\LogListener;

class LogoutListener extends LogListener
{

    public function handle(LogoutEvent $event)
    {
        parent::handle($event);
    }

}