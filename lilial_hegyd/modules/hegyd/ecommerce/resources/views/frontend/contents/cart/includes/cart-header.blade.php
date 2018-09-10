@php
$cart_counter = $cart->countProduct();
@endphp

<a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.index')) }}" title="@lang('hegyd-ecommerce::cart.buttons.see_cart')" class="dropdown-toggle count-info" data-cart-template="cart-header">
    <i class="fa fa-shopping-cart fa-2x"></i>
    @if($cart_counter)
        <span class="badge">{{ $cart_counter < 100 ? $cart_counter : '99+' }}</span>
    @endif
</a>