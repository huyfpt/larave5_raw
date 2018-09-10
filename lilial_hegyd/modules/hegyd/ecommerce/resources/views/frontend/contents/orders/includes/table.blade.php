<table class="table table-striped">
    <thead>
    <tr>
        <th class="col-md-4 text-left">@lang('hegyd-ecommerce::orders.fields.product_name')</th>
        <th class="col-md-3">@lang('hegyd-ecommerce::orders.fields.product_reference')</th>
        <th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.unit_price_ht')</th>
        <th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.unit_price_ttc')</th>
        <th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.quantity')</th>
        <th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.total_line_ht')</th>
        {{--<th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.vat')</th>--}}
        {{--<th class="col-md-2">@lang('hegyd-ecommerce::orders.fields.total_line_ttc')</th>--}}
    </tr>
    </thead>
    <tbody>
    @if($order->lines->count())
        @foreach($order->lines as $line)
            @include('hegyd-ecommerce::frontend.contents.orders.includes.row-item')
        @endforeach
    @else
        <tr><td colspan="4">@lang('hegyd-ecommerce::orders.labels.no_product')</td></tr>
    @endif
    </tbody>
</table>