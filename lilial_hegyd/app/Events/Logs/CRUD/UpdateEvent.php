<?php namespace App\Events\Logs\CRUD;

use App\Events\Logs\LogEvent;

class UpdateEvent extends LogEvent
{

    public function getEvent()
    {
        return $this->getModelAlias() . '.update';
    }

    public function getMessage()
    {
        $fullname = 'Utilisateur inconnu';
        $user = $this->getUser();

        if ($user)
        {
            $fullname = $user->fullname();
        }

        return trans('logs.messages.update.' . $this->getModelAlias(), ['fullname' => $fullname, 'entity_name' => $this->getEntityName($this->getModel())]);
    }
}