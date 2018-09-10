<?php


namespace App\Services\Common;


use App\Models\Common\Notification;

class NotificationService
{

    public function typeText($type)
    {
        if (isset(Notification::$types[$type]))
        {
            return trans(Notification::$types[$type] . '.text');
        }

        return trans('app.unknown');
    }

    public function typeClass($type)
    {
        if (isset(Notification::$types[$type]))
        {
            return trans(Notification::$types[$type] . '.class');
        }

        return 'label-default';
    }
}