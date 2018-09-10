<?php namespace App\Listeners\Logs\Auth;

use App\Events\Logs\Auth\LogoutAsEvent;
use App\Listeners\Logs\LogListener;

class LogoutAsListener extends LogListener
{

    public function handle(LogoutAsEvent $event)
    {
        parent::handle($event);
    }

}