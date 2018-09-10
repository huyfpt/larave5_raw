@extends(config('hegyd-ecommerce.main_layout.frontend'))

@section('content')
    <div class="section section-header">
        <div class="row inner-section">
            <header class="text-center">
                <h1>{!! $title !!}</h1>
            </header>
        </div>
    </div>

    <div class="section section-validation">
        <div class="inner-section">
            <div class="section-content text-center">
                <div class="ico-valid"></div>
                <h3 class="title-valid">
                    @lang('hegyd-ecommerce::orders.labels.payment_failed', [
                    'route'     => route(config('hegyd-ecommerce.routes.frontend.cart.index'))
                    ])
                </h3>
            </div>
        </div>
    </div>
@endsection