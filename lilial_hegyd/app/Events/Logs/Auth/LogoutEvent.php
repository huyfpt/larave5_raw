<?php namespace App\Events\Logs\Auth;

use App\Events\Logs\LogEvent;

class LogoutEvent extends LogEvent
{

    protected $entity_name_key = ['firstname', 'lastname'];

    public function getEvent()
    {
        return $this->getModelAlias() . '.logout';
    }

    public function getMessage()
    {
        $fullname = 'Utilisateur inconnu';
        $user = $this->getUser();

        if ($user)
        {
            $fullname = $user->fullname();
        }

        return trans('logs.messages.logout', ['fullname' => $fullname]);
    }
}