<?php namespace App\Events\Logs\Generic;

use App\Events\Logs\LogEvent;

class GenericEvent extends LogEvent
{
    protected $message;
    protected $event;

    public function __construct($event = "user.action", $message = "", $user = null){
        $this->message  = $message;
        $this->event    = $event;

        parent::__construct(null, $user);
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getMessage()
    {

        return trans($this->message);
    }
}