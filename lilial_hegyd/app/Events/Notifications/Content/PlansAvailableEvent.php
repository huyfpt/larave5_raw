<?php namespace App\Events\Notifications\Content;


use App\Events\Notifications\NotificationEvent;
use App\Models\Common\User;
use App\Notifications\Content\PlansAvailable;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use Hegyd\Plans\Models\Plans;

class PlansAvailableEvent extends NotificationEvent
{

    protected $plans;

    public function __construct(Plans $plans)
    {
        $this->plans = $plans;
    }

    public function getUsers()
    {
        return app(UserRepositoryInterface::class)->findByPermission('extranet.plans.index');
    }

    public function getNotificationModel()
    {
        return new PlansAvailable($this->plans);
    }
}