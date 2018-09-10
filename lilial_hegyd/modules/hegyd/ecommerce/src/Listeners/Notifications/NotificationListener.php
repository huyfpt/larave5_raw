<?php namespace Hegyd\eCommerce\Listeners\Notifications;


use Hegyd\eCommerce\Events\Notifications\NotificationEvent;
use Illuminate\Support\Facades\Log;
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