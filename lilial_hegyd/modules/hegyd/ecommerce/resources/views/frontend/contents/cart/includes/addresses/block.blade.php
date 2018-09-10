<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::cart.title.invoice_address')</h3>
        <hr />
        @include('hegyd-ecommerce::frontend.contents.cart.includes.addresses.item', ['address' => $cart->invoiceAddress, 'type' => \Hegyd\eCommerce\Models\eCommerce\Cart::ADDRESS_TYPE_INVOICE])
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::cart.title.delivery_address')</h3>
        <hr />
        @include('hegyd-ecommerce::frontend.contents.cart.includes.addresses.item', ['address' => $cart->deliveryAddress, 'type' => \Hegyd\eCommerce\Models\eCommerce\Cart::ADDRESS_TYPE_DELIVERY])
    </div>
</div>
