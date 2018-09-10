<?php namespace App\Listeners\Logs\Auth;

use App\Events\Logs\Auth\LoginEvent;
use App\Listeners\Logs\LogListener;

class LoginListener extends LogListener
{

    public function handle(LoginEvent $event)
    {
        parent::handle($event);
    }

}