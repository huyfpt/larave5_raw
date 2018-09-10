<div class="cart-details">
    <table class="table table-basket">
    <thead>
        <tr>
            <th class="col-md-4 text-left">@lang('hegyd-ecommerce::orders.fields.product_name')</th>
            <th class="col-md-3">@lang('hegyd-ecommerce::orders.fields.product_reference')</th>
            <th class="basket-price text-center">@lang('hegyd-ecommerce::orders.fields.unit_price_ht')</th>
            <th class="basket-price text-center">@lang('hegyd-ecommerce::orders.fields.unit_price_ttc')</th>
            <th class="basket-quantity text-center">@lang('hegyd-ecommerce::orders.fields.quantity')</th>
            <th class="basket-price text-right">@lang('hegyd-ecommerce::orders.fields.total_line_ht')</th>
            <th class="basket-price">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @if($model->lines->count())
            @foreach($model->lines as $line)
                @include('hegyd-ecommerce::backend.contents.orders.includes.lines.row-item')
            @endforeach
        @else
            <tr><td colspan="5">@lang('hegyd-ecommerce::orders.labels.no_product')</td></tr>
        @endif
    </tbody>
</table>
</div>