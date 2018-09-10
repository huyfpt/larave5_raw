@extends(config('hegyd-ecommerce.main_layout.backend'))
@inject('orderService', 'Hegyd\eCommerce\Services\eCommerce\OrderService')
@inject('productService', 'Hegyd\eCommerce\Services\ProductCatalog\ProductService')

@section('title')
    {!! $title !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="white-box printableArea">
                @include('hegyd-ecommerce::backend.contents.orders.includes.details')
            </div>
        </div>
    </div>
    <div class="row">@include('hegyd-ecommerce::backend.contents.orders.includes.infos')</div>          




                 
                        <!-- <h3>@lang('hegyd-ecommerce::orders.title.edit', ['name' => $model->reference])</h3> -->

    @include('hegyd-ecommerce::backend.contents.orders.includes.histories')
    @if($model->status < \Hegyd\eCommerce\Models\eCommerce\Order::STATUS_ARCHIVED)
        @include('hegyd-ecommerce::backend.contents.orders.includes.lines.modal')
        @include('hegyd-ecommerce::backend.contents.orders.includes.modal-status')
    @endif
@endsection