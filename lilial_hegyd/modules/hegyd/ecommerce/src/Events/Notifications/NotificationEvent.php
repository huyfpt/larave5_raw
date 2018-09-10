<?php namespace Hegyd\eCommerce\Events\Notifications;

use Hegyd\eCommerce\Events\Event;
use Hegyd\eCommerce\Models\Common\User;
use Hegyd\eCommerce\Repositories\Contracts\Common\UserRepositoryInterface;

abstract class NotificationEvent extends Event
{

    abstract public function getUsers();

    abstract public function getNotificationModel();

    public function getAdminUsers()
    {
        $users = app(config('hegyd-ecommerce.repositories.user'))->findByRole('admin');

        return $users;
    }
}
