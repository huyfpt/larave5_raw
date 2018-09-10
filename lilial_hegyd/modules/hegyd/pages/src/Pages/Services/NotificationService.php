<?php namespace Hegyd\Pages\Services;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

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
}
