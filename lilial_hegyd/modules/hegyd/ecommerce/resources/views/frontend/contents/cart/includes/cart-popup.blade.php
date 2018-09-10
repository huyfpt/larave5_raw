<div class="row text-center">
    <div class="toastR-message col-md-12">
        <h4>{{ isset($text) ? $text : trans('hegyd-ecommerce::cart.labels.product_added') }}</h4>
        @if(isset($success) && $success)
            <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.index')) }}" class="btn btn-light">
                @lang('hegyd-ecommerce::cart.buttons.see_cart')
            </a>
        @endif
    </div>
</div>