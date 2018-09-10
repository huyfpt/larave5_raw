<div class="row">
    <div id="order-lines-table" class="col-md-12 table-responsive">
        @include('hegyd-ecommerce::frontend.contents.orders.includes.table')
    </div>
</div>
<hr>
<div class="row">
    <!-- accepted payments column -->
    <div class="col-md-8">
        <p class="lead">@lang('hegyd-ecommerce::orders.fields.payment_means')</p>
        <p class="text-muted well well-sm no-shadow">
            @if($paid_at = $order->paid_at)
                @lang('hegyd-ecommerce::orders.messages.paid_at', [
               'date'     => $paid_at->format('d/m/Y H:i:s'),
               'provider' => app(\Hegyd\eCommerce\Services\eCommerce\OrderService::class)->paymentMeansText($order->payment_means)
               ])
            @endif
        </p>
        @if($order->comment)
            <p class="lead">@lang('hegyd-ecommerce::orders.fields.comment')</p>
            <p class="text-muted well well-sm no-shadow">
                {{ $order->comment }}
            </p>
        @endif
    </div>
    <!-- /.col -->
    <div class="col-md-4">
        <p class="lead">@lang('hegyd-ecommerce::orders.labels.all_total')</p>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th class="col-md-7 text-right">@lang('hegyd-ecommerce::orders.fields.delivery_price')</th>
                    <td class="text-right">{{ app_number_format($order->delivery_price) }}&nbsp;€</td>
                </tr>
                <tr>
                    <th class="col-md-7 text-right">@lang('hegyd-ecommerce::orders.fields.total_ht')</th>
                    <td class="text-right">{{ app_number_format($order->total_ht) }}&nbsp;€</td>
                </tr>
                <tr>
                    <th class="col-md-7 text-right">@lang('hegyd-ecommerce::orders.fields.total_vat')</th>
                    <td class="text-right">{{ app_number_format($order->total_vat) }}&nbsp;€</td>
                </tr>
                <tr>
                    <th class="col-md-7 text-right">@lang('hegyd-ecommerce::orders.fields.total_ttc')</th>
                    <td class="text-right">{{ app_number_format($order->total_ttc) }}&nbsp;€</td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>