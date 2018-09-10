<?php namespace App\Listeners\Logs\Auth;

use App\Events\Logs\Auth\LoginAsEvent;
use App\Listeners\Logs\LogListener;

class LoginAsListener extends LogListener
{

    public function handle(LoginAsEvent $event)
    {
        parent::handle($event);
    }

}