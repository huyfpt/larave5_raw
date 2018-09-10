<?php namespace App\Events\Notifications;

use App\Events\Event;
use App\Models\Common\User;
use App\Repositories\Contracts\Common\UserRepositoryInterface;

abstract class NotificationEvent extends Event
{

    abstract public function getUsers();

    abstract public function getNotificationModel();

    public function getAdminUsers()
    {
        $users = app(UserRepositoryInterface::class)->findByRole('admin');

        return $users;
    }
}
