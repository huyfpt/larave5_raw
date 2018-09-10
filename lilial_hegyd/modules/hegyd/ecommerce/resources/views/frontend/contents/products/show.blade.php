@inject('productService', 'Hegyd\eCommerce\Services\ProductCatalog\ProductService')
@extends(config('hegyd-ecommerce.main_layout.frontend'))

@section('title')
    {{$title}}
@endsection

@section('content')
    {!! Form::hidden('product_id', $product->id, ['id' => 'product_id']) !!}


    <div class="row product-page">
        <div class="col-md-9 col-lg-9 col-sm-7">
            <div class="white-box clearfix">
                <div class="col-md-4 text-center">
                    @if($product->visual)
                        <a class="col-md-12 main-visual" href="{{$product->media()}}" data-fancybox="gallery" data-caption="{{$product->title()}}">
                            <img src="{{$product->media()}}" alt="{{$product->title()}}" class="col-md-12"/>
                        </a>
                    @else
                        <img src="{{$product->media()}}" alt="" class="col-md-12">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="m-b-0 m-t-0">{{$product->name}}</h2>
                            <small class="text-muted db">
                                @if($stock > 0)
                                    {{trans_choice('hegyd-ecommerce::products.labels.stock', $stock)}}
                                @else
                                    @lang('hegyd-ecommerce::products.labels.out_of_stock')
                                @endif
                            </small>
                        </div>
                        <div class="col-md-3 text-right">
                            <a href="{{route(config('hegyd-ecommerce.routes.frontend.product.index'))}}"
                               class="btn btn-default">
                                <i class="fa fa-arrow-left"></i>
                                @lang('hegyd-ecommerce::products.buttons.back_index')
                            </a>
                        </div>
                    </div>
                    <hr />
                    <h4 class="box-title m-b-5 m-t-20">@lang('hegyd-ecommerce::products.fields.reference') : 
                        <span class="unstrong"> {{$product->reference}}</span>
                    </h4>
                    @if($product->category)
                    <h4 class="box-title m-b-5 m-t-15">@lang('hegyd-ecommerce::products.fields.category') :
                        <span class="unstrong"> {{$product->category->name}}</span>
                    </h4>
                    @endif
                    <h4 class="box-title m-b-5 m-t-15">@lang('hegyd-ecommerce::products.fields.description') :</h4>
                    <p class="text-left">{!! $product->description !!}</p>
                    <hr />
                    <div>
                        @foreach($product->visuals()->orderBy('position')->get() as $visual)
                        <a class="col-md-2 second-visual m-t-5 m-b-10" href="{{$visual->image()}}" data-fancybox="gallery" data-caption="{{$product->title()}}">
                            <img src="{{$visual->media}}" alt="" class="col-md-4"/>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-5">
            <div class="white-box">
                <small>@lang('hegyd-ecommerce::products.fields.price')</small>
                <h2>{{number_format($product->price, 2, ',', '&nbsp;')}}&nbsp;€</h2>
                <hr /><small>@lang('hegyd-ecommerce::products.fields.price_ttc')</small>
                <h2>{{number_format($productService->priceTtc($product), 2, ',', '&nbsp;')}}&nbsp;€</h2>
                <hr /> 

                 @if($stock > 0)
                <div class="form-group">
                    {!! Form::number('quantity', 1, [
                    'id'        => 'quantity',
                    'class'     => 'form-control fiche-wrap',
                    'min'       => 1,
                    'max'       => $stock,
                    'step'      => 1,
                    ]) !!}
                </div>
                    <a class="btn btn-block btn-success add-to-cart"
                       href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.add')) }}"
                       title="@lang('hegyd-ecommerce::cart.buttons.add_to_cart')">
                        <span><i class="icon icon-cart"></i> @lang('hegyd-ecommerce::cart.buttons.add_to_cart')</span>
                    </a>
                @else
                    <span>@lang('hegyd-ecommerce::products.labels.out_of_stock')</span>
                @endif   
            </div>
        </div>
    </div>
@endsection
@push('stylesheets')
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/fancybox/dist/jquery.fancybox.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/fancybox/dist/jquery.fancybox.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/ecommerce.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/products/show.js') !!}
@endpush