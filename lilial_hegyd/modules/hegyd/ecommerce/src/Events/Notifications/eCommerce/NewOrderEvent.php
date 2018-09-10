<?php namespace Hegyd\eCommerce\Events\Notifications\eCommerce;

use Hegyd\eCommerce\Events\Notifications\NotificationEvent;
use Hegyd\eCommerce\Mails\eCommerce\OrderCreated;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Notifications\eCommerce\NewOrder;
use Hegyd\eCommerce\Services\eCommerce\OrderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewOrderEvent extends NotificationEvent
{

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        Mail::queue(new OrderCreated($order));
        app(OrderService::class)->decrementStock($order);
    }

    public function getUsers()
    {
        return $this->getAdminUsers();
    }

    public function getNotificationModel()
    {
        return new NewOrder($this->order);
    }

    public function getOrder()
    {
        return $this->order;
    }
}