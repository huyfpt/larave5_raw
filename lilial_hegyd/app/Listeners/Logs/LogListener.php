<?php namespace App\Listeners\Logs;


use App\Events\Logs\LogEvent;
use Hegyd\Logs\Models\Log;

abstract class LogListener
{

    protected $event;

    public function handle(LogEvent $event)
    {
        $user = $event->getUser();
        $message = $event->getMessage();
        $event_str = $event->getEvent();
        $data = $event->getData();

        $this->createLog($user, $message, $event_str, $data);
    }

    protected function createLog($user, $message, $event, $data)
    {
        $log = new Log();
        $log->message = $message;
        $log->event = $event;
        $log->data = $data;
        $log->user()->associate($user);
        $log->save();
    }
}