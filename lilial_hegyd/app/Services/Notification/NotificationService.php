<?php

namespace App\Services\Notification;

use Session;
use Lang;

/**
 * Contains some useful methods for displaying notifications to the front
 * - flash notifications : display once in javascript
 * @class NotificationService
 * @package App\Services\Notification;
 */
class NotificationService
{

    /**
     * Add a flash notification in session which will be displayed one time in the View
     *
     * @param string $string
     * @param string $type
     */
    public function flashNotify($string, $type)
    {
        Session::put('flash_notification', [
            'text' => Lang::get($string),
            'type' => $type,
        ]);
    }

    /**
     * return boolean true of there is flash_notifiations
     */
    public function hasFlashNotification()
    {
        return Session::has('flash_notification');
    }

    /**
     * return boolean true of there is flash_notifiations
     */
    public function getFlashNotifications()
    {
        $notif = Session::get('flash_notification');
        Session::forget('flash_notification');
        return $notif;
    }

    /**
     * Add a alert notification in session which will be displayed one time in the View
     *
     * @param string $string
     * @param string $type
     */
    public function alertNotify($string, $type)
    {
        Session::put('alert_notification', [
            'text' => Lang::get($string),
            'type' => $type,
        ]);
    }

    /**
     * return boolean true of there is alert_notifiations
     */
    public function hasAlertNotification()
    {
        return Session::has('alert_notification');
    }

    /**
     * return boolean true of there is alert_notifiations
     */
    public function getAlertNotifications()
    {
        $notif = Session::get('alert_notification');
        Session::forget('alert_notification');
        return $notif;
    }
}
