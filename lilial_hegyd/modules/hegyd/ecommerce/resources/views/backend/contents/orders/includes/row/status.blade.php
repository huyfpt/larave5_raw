@if(in_array($value, [
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_WAITING_FOR_PAYMENT,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_PAID,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_IN_PREPARATION,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_TREATED,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_SHIPPED,
]))
    <span class="label label-warning">{{ trans('hegyd-ecommerce::' .\Hegyd\eCommerce\Models\eCommerce\Order::$status[$value]) }}</span>
@elseif(in_array($value, [
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_CANCELLED,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_ERROR
]))
    <span class="label label-danger">{{ trans('hegyd-ecommerce::' .\Hegyd\eCommerce\Models\eCommerce\Order::$status[$value]) }}</span>
@elseif(in_array($value, [
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_DELIVERED,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_ARCHIVED,
\Hegyd\eCommerce\Models\eCommerce\Order::STATUS_REFUND,
]))
    <span class="label label-success">{{ trans('hegyd-ecommerce::' .\Hegyd\eCommerce\Models\eCommerce\Order::$status[$value]) }}</span>
@else
    <span class="label label-default">@lang('app.unknown') {{$value}}</span>
@endif
