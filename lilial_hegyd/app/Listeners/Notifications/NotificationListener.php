<?php namespace App\Listeners\Notifications;


use App\Events\Notifications\NotificationEvent;
use Illuminate\Support\Facades\Notification;

abstract class NotificationListener
{

    protected $event;

    public function handle(NotificationEvent $event)
    {
        $users = $event->getUsers();

        Notification::send($users, $event->getNotificationModel());
    }

}