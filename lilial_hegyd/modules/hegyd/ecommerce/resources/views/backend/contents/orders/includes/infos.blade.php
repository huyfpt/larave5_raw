

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <h3 class="box-title">@lang('hegyd-ecommerce::orders.labels.invoice_address')</h3>
        <hr />
        
        <address>
            <strong>{{ $model->invoice_company }}</strong><br>
            <strong>{{ $model->invoice_firstname }} {{ $model->invoice_lastname }}</strong><br>
            {{ $model->invoice_address }}, <br>
            @if($model->invoice_additional_1)
                {{ $model->invoice_additional_1 }}, <br>
            @endif
            @if($model->invoice_additional_2)
                {{ $model->invoice_additional_2 }}, <br>
            @endif
            {{ $model->invoice_zip }} {{ $model->invoice_city }}<br>
            @if($model->invoice_country)
                {{ $model->invoice_country }}<br>
            @endif
            @if($model->invoice_phone)
                @lang('app.labels.phone', ['phone' => $model->invoice_phone])<br>
            @endif
            @if($model->invoice_email)
                @lang('app.labels.email', ['email' => $model->invoice_email])
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
            <strong>{{ $model->delivery_company }}</strong><br>
            <strong>{{ $model->delivery_firstname }} {{ $model->delivery_lastname }}</strong><br>
            {{ $model->delivery_address }}, <br>
            @if($model->delivery_additional_1)
                {{ $model->delivery_additional_1 }}, <br>
            @endif
            @if($model->delivery_additional_2)
                {{ $model->delivery_additional_2 }}, <br>
            @endif
            {{ $model->delivery_zip }} {{ $model->delivery_city }}<br>
            @if($model->delivery_country)
                {{ $model->delivery_country }}<br>
            @endif
            @if($model->delivery_phone)
                @lang('app.labels.phone', ['phone' => $model->delivery_phone])<br>
            @endif
            @if($model->delivery_email)
                @lang('app.labels.email', ['email' => $model->delivery_email])
            @endif
        </address>
    </div>
</div>

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 min-box">
    <div class="white-box">
        <b>@lang('hegyd-ecommerce::orders.fields.created_at') : </b> {{ $model->created_at->format('d/m/Y') }}<br><br>
        <b>@lang('hegyd-ecommerce::orders.fields.reference') :</b> {{ $model->reference }}<br><br>
        <b>@lang('hegyd-ecommerce::orders.fields.status') :</b> {{ $orderService->statusText($model->status) }}<br>
        <hr />
        <a href="{{ route(config('hegyd-ecommerce.routes.backend.order.download-invoice'), $model->id) }}"
        target="_blank"
        class="btn btn-primary">
            <i class="fa fa-print"></i> @lang('hegyd-ecommerce::orders.buttons.print_invoice')
        </a>
    </div>
</div>