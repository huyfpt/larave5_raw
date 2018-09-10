@extends(config('hegyd-ecommerce.main_layout.frontend'))
@inject('orderService', 'Hegyd\eCommerce\Services\eCommerce\OrderService')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box printableArea">
                @include('hegyd-ecommerce::frontend.contents.orders.includes.details')
            </div>
        </div>
    </div>
    <div class="row">@include('hegyd-ecommerce::frontend.contents.orders.includes.infos')</div>
@endsection