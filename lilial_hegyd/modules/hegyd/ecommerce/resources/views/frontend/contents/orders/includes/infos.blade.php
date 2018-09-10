

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::orders.labels.invoice_address')</h3>
        <hr>
        <address>
            <strong>{{ $order->invoice_company }}</strong><br>
            <strong>{{ $order->invoice_firstname }} {{ $order->invoice_lastname }}</strong><br>
            {{ $order->invoice_address }}, <br>
            @if($order->invoice_additional_1)
                {{ $order->invoice_additional_1 }}, <br>
            @endif
            @if($order->invoice_additional_2)
                {{ $order->invoice_additional_2 }}, <br>
            @endif
            {{ $order->invoice_zip }} {{ $order->invoice_city }}<br>
            @if($order->invoice_country)
                {{ $order->invoice_country }}<br>
            @endif
            @if($order->invoice_phone)
                @lang('app.labels.phone', ['phone' => $order->invoice_phone])<br>
            @endif
            @if($order->invoice_email)
                @lang('app.labels.email', ['email' => $order->invoice_email])
            @endif
        </address>
    </div>
</div>
<!-- /.col -->
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::orders.labels.delivery_address')</h3>
        <hr />
        <address>
            <strong>{{ $order->delivery_company }}</strong><br>
            <strong>{{ $order->delivery_firstname }} {{ $order->delivery_lastname }}</strong><br>
            {{ $order->delivery_address }}, <br>
            @if($order->delivery_additional_1)
                {{ $order->delivery_additional_1 }}, <br>
            @endif
            @if($order->delivery_additional_2)
                {{ $order->delivery_additional_2 }}, <br>
            @endif
            {{ $order->delivery_zip }} {{ $order->delivery_city }}<br>
            @if($order->delivery_country)
                {{ $order->delivery_country }}<br>
            @endif
            @if($order->delivery_phone)
                @lang('app.labels.phone', ['phone' => $order->delivery_phone])<br>
            @endif
            @if($order->delivery_email)
                @lang('app.labels.email', ['email' => $order->delivery_email])
            @endif
        </address>
    </div>
</div>

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <b>@lang('hegyd-ecommerce::orders.fields.created_at') : </b> {{ $order->created_at->format('d/m/Y') }}<br><br>
        <b>@lang('hegyd-ecommerce::orders.fields.reference') :</b> {{ $order->reference }}<br><br>
        <b>@lang('hegyd-ecommerce::orders.fields.status') :</b> {{ $orderService->statusText($order->status) }}<br>
        <hr />
        <a target="_blank" href="{{ route(config('hegyd-ecommerce.routes.frontend.order.download-invoice'), $order->id) }}"
           class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-print"></i> @lang('hegyd-ecommerce::orders.buttons.print_invoice')
        </a>
    </div>
    <!-- /.col -->
</div>