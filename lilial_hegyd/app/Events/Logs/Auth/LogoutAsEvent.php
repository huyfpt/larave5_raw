<?php namespace App\Events\Logs\Auth;

use App\Events\Logs\LogEvent;

class LogoutAsEvent extends LogEvent
{

    protected $entity_name_key = ['firstname', 'lastname'];

    public function getEvent()
    {
        return $this->getModelAlias() . '.logout_as';
    }

    public function getMessage()
    {
        $fullname = 'Utilisateur inconnu';
        $impersonate_fullname = 'Utilisateur inconnu';

        $user = $this->getUser();
        $impersonate_user = $this->getModel();

        if ($user)
        {
            $fullname = $user->fullname();
        }
        if ($impersonate_user)
        {
            $impersonate_fullname = $impersonate_user->fullname();
        }

        return trans('logs.messages.logout_as', ['fullname' => $fullname, 'impersonate_fullname' => $impersonate_fullname,]);
    }
}