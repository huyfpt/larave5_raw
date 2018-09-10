<?php namespace App\Events\Logs\CRUD;

use App\Events\Logs\LogEvent;

class DeleteEvent extends LogEvent
{
    public function getEvent()
    {
        return $this->getModelAlias() . '.delete';
    }

    public function getMessage()
    {
        $fullname = 'Utilisateur inconnu';
        $user = $this->getUser();

        if ($user)
        {
            $fullname = $user->fullname();
        }

        return trans('logs.messages.delete.' . $this->getModelAlias(), ['fullname' => $fullname, 'entity_name' => $this->getEntityName($this->getModel())]);
    }
}