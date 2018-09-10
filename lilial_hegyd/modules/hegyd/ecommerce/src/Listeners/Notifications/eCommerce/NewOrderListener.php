<?php namespace Hegyd\eCommerce\Listeners\Notifications\eCommerce;


use Hegyd\eCommerce\Events\Notifications\eCommerce\NewOrderEvent;
use Hegyd\eCommerce\Listeners\Notifications\NotificationListener;
use Hegyd\eCommerce\Mails\eCommerce\OrderCreated;
use Illuminate\Support\Facades\Log;

class NewOrderListener extends NotificationListener
{

    public function handle(NewOrderEvent $event)
    {
        parent::handle($event);
    }
}