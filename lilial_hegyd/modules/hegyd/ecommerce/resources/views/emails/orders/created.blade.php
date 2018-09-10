@extends(config('hegyd-ecommerce.main_layout.email'))

@section('message')
    @lang('hegyd-ecommerce::emails.orders.created.message', [
        'site_name'     => $site_name,
        'site_domain'   => $site_domain,
        'order_reference' => $order->reference,
    ])

    @include('hegyd-ecommerce::emails.orders.includes.details')
    @lang('hegyd-ecommerce::emails.orders.created.message2')
@endsection

