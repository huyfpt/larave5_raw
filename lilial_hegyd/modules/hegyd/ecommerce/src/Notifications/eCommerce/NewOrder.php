<?php namespace Hegyd\eCommerce\Notifications\eCommerce;

use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Notifications\AbstractNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class NewOrder extends AbstractNotification
{

    public function __construct(Order $model, $type = null)
    {
        parent::__construct($model, $type);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->getMessage(),
            'href'    => $this->getHref(),
        ];
    }

    public function getMessage()
    {
        return trans('hegyd-ecommerce::notifications.messages.orders.created', ['reference' => $this->model->reference]);
    }

    public function getHref()
    {
        return route(config('hegyd-ecommerce.routes.backend.order.edit'), $this->model->id);
    }
}
