
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::cart.title.payment_means')</h3>
        <hr />
        <label class="blockLabel paypal last">
            <span>
                <span>
                    {!! Form::radio('payment_means',
                     \Hegyd\eCommerce\Models\eCommerce\Order::PAYMENT_MEANS_PAYPAL,
                     $cart->payment_means == \Hegyd\eCommerce\Models\eCommerce\Order::PAYMENT_MEANS_PAYPAL,
                     [
                    'href' => route(config('hegyd-ecommerce.routes.frontend.cart.update')),
                    'class' => 'payment_means',
                    'required',
                    ]) !!}
                    <span>
                    <i class="fa fa-cc-paypal text-info"></i>
                    @lang('hegyd-ecommerce::orders.payment_means.paypal')</span>
                </span>
            </span>
        </label>
         <hr />
    </div>
</div>