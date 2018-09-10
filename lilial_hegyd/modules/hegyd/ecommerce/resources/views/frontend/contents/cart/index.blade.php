@extends(config('hegyd-ecommerce.main_layout.frontend'))

@section('content')
    <!--header title-->
    <!-- section basket -->

<div class="block-articles"  data-cart-template="cart-details">
    @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-details')
</div>
@endsection

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/ecommerce/dependencies/select2/dist/css/select2.min.css') !!}
@endpush

@push('scripts')
    {!! Html::script('/vendor/hegyd/ecommerce/dependencies/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') !!}

    {!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/i18n/fr.js') !!}

    {!! Html::script('/vendor/hegyd/ecommerce/js/ecommerce.js') !!}
    {!! Html::script('/vendor/hegyd/ecommerce/js/cart/index.js') !!}
@endpush