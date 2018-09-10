<?php namespace Hegyd\eCommerce\Observers\eCommerce;


use Hegyd\eCommerce\Events\NotificationEvent;
use Hegyd\eCommerce\Events\Notifications\eCommerce\NewOrderEvent;
use Hegyd\eCommerce\Mails\eCommerce\OrderCreated;
use Hegyd\eCommerce\Models\Common\Notification;
use Hegyd\eCommerce\Models\Common\User;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Models\eCommerce\OrderHistory;
use Hegyd\eCommerce\Observers\BaseObserver;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderHistoryRepositoryInterface;
use Hegyd\eCommerce\Services\eCommerce\OrderService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{

    protected $entityNameKey = 'reference';

    public function created($model)
    {
        $text = trans('hegyd-ecommerce::orders.histories.created', ['status' => app(OrderService::class)->statusText($model->status)]);
        $this->_createHistory($model, $text);
    }

    public function saved($model)
    {
        // Récupérations du NOM des champs modifiés
        $keys = array_keys($model->getDirty());
        // Récupération des valeurs ORIGINALES des champs modifiés
        $before = array_get_values($model->getOriginal(), $keys);
        $after = $model->getDirty();

        if (isset($before['status']) && isset($after['status']) && $before['status'] != $after['status'])
        {
            $new_status = $after['status'];
            $text = trans('hegyd-ecommerce::orders.histories.update_status', ['status' => app(OrderService::class)->statusText($new_status)]);
            $this->_createHistory($model, $text);
//
//            switch ($new_status)
//            {
//                case Order::STATUS_ON_GOING:
//                    app(\App\Services\Mail\OrderService::class)->orderOnGoing($model);
//                    break;
//
//                case Order::STATUS_VALIDATED:
//                    app(\App\Services\Mail\OrderService::class)->orderValidated($model);
//                    break;
//            }

        }
    }

    public function _createHistory($model, $text)
    {
        $user = auth()->user();

        if ( ! $user)
        {
            $user = User::find(1)->first();
        }

        $history = new OrderHistory();
        $history->user()->associate($user);
        $history->order()->associate($model);
        $history->text = $text;

        app(OrderHistoryRepositoryInterface::class)->save($history->getAttributes());
    }
}