@if($cart->lines->count())
    @inject('cartService', 'Hegyd\eCommerce\Services\eCommerce\CartService')
    @inject('productService', 'Hegyd\eCommerce\Services\ProductCatalog\ProductService')
    {!! Form::open(['url' => route(config('hegyd-ecommerce.routes.frontend.cart.payment')), 'method' => 'POST']) !!}

    <article data-template="cart-details" class="cart-details">
        <div class="row">

            <div class="icol-md-12 col-xs-12">
                <div class="white-box printableArea">
                    <div class="cart-details">
                        <div class="table-basket">
                            @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-table')
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user())
                @include('hegyd-ecommerce::frontend.contents.cart.includes.addresses.block')
            @endif

            @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-payment-means')

        </div>
        @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-footer')
    </article>
    
    {!! Form::close() !!}
          

    <div class="clearfix"></div>
    @if(auth()->guest())
        @include('hegyd-ecommerce::frontend.auth.includes.form')
    @endif

    <div id="cart-modal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
@else
    <div class="text-center">
        <h2>@lang('hegyd-ecommerce::cart.labels.empty_cart')</h2>
        <a href="{{ route(config('hegyd-ecommerce.routes.frontend.product.index'))}}" class="btn btn-default">@lang('hegyd-ecommerce::cart.buttons.continue')</a>
    </div>
@endif
