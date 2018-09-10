
<div class="white-box clearfix">
    <div class="basket-cmd">
        <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.reset')) }}"
           class="reset-cart btn btn-default pull-left">
            @lang('hegyd-ecommerce::cart.buttons.reset')
        </a>
        @if($cartService->cartCanBeValidated($cart))
            {!! Form::submit(trans('hegyd-ecommerce::cart.buttons.submit'), ['class' => 'btn-order btn btn-info  pull-right']) !!}
        @else
            <span class="btn-order btn btn-default btn-lg disabled pull-right col-md-1-offset">@lang('hegyd-ecommerce::cart.buttons.submit')</span>
        @endif
        <a href="{{ route(config('hegyd-ecommerce.routes.frontend.product.index'))}}" class="btn btn-default pull-right">
            @lang('hegyd-ecommerce::cart.buttons.continue')
        </a>
    </div>
</div>