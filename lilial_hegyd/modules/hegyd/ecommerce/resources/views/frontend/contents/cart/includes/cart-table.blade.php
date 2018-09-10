<table class="table-basket table">
    <thead>
    <tr>
        <th class="basket-article" colspan="2">@lang('hegyd-ecommerce::cart.fields.products')</th>
        <th class="basket-price text-right">@lang('hegyd-ecommerce::cart.fields.unit_price')</th>
        <th class="basket-price text-right">@lang('hegyd-ecommerce::cart.fields.unit_price_ttc')</th>
        <th class="basket-qte text-center">@lang('hegyd-ecommerce::cart.fields.quantity')</th>
        <th class="basket-prices text-right">@lang('hegyd-ecommerce::cart.fields.total_ht')</th>
        {{--<th class="basket-tva">@lang('hegyd-ecommerce::cart.fields.vat')</th>--}}
        {{--<th class="basket-prices text-right">@lang('hegyd-ecommerce::cart.fields.total_ttc')</th>--}}
        <th class="basket-action"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($cart->lines as $line)
        @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-table-row')
    @endforeach
    </tbody>
    <tfoot>
    @if($cartService->currentTotalPrice() < $cartService->getCartMinimumPrice())
        <tr>
            <td colspan="7">
                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i> @lang('hegyd-ecommerce::cart.labels.minimum_price', ['price' => app_number_format($cartService->getCartMinimumPrice())])
                </div>
            </td>
        </tr>
    @endif
    <tr>
        <td colspan="2" rowspan="5" class="basket-promo">
            @if(auth()->user())
                <a class="leave-comment" href="javascrit:void(0)"><i class="fa fa-comments" aria-hidden="true"></i> @lang('hegyd-ecommerce::cart.labels.comment')</a>
                <div class="comment-area {{ $cart->comment ? 'show' : 'hide' }}">
                {!! Form::textarea('comment', $cart->comment, [
                    'class' => 'comment col-md-6',
                    'rows' => 3,
                    'href' => route(config('hegyd-ecommerce.routes.frontend.cart.update'))
                ]) !!}
                </div>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3" class="basket-total">@lang('hegyd-ecommerce::cart.fields.total_products_ht')</td>
        <td colspan="1" class="price text-right">{{ app_number_format($cartService->currentTotalLinesPrice()) }}&nbsp;€</td>
        <td colspan="1"></td>
    </tr>
    <tr>
        <td colspan="3" class="basket-total">@lang('hegyd-ecommerce::cart.fields.delivery_price')</td>
        <td colspan="1" class="price text-right">{{ app_number_format($cartService->currentDeliveryPrice()) }}&nbsp;€</td>
        <td colspan="1"></td>
    </tr>
    <tr>
        <td colspan="3" class="basket-tva">@lang('hegyd-ecommerce::cart.fields.vat')</td>
        <td colspan="1" class="price text-right">{{ app_number_format($cartService->currentVatPrice()) }}&nbsp;€</td>
        <td colspan="1"></td>
    </tr>
    <tr>
        <td colspan="3" class="basket-total"><b>@lang('hegyd-ecommerce::cart.fields.total_ttc')</b></td>
        <td colspan="1" class="price text-right"><b>{{ app_number_format($cartService->currentTotalPrice(true)) }}&nbsp;€</b></td>
        <td colspan="1"></td>
    </tr>
    </tfoot>
</table>