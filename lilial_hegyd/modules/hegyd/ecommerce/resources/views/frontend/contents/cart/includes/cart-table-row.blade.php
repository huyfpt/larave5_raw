@php
$product = $line->product;
$stock = app(\Hegyd\eCommerce\Services\ProductCatalog\ProductService::class)->currentStock($product);
@endphp

<tr data-product-id="{{ $product->id }}" class="cart-product-item">
    <td class="article-thumb text-center">
        <a href="{{ $product->url() }}">
            <img src="{{ $product->media() }}" width="100">
        </a>
    </td>
    <td class="article-desc">
        <p class="article-cat">
            <a href="{{route(config('hegyd-ecommerce.routes.frontend.product.show'), $product->id)}}">{{ $product->title() }}</a>
            @if($category = $product->category)
                <div>{{$category->name}}</div>
            @endif
        </p>
    </td>
    <td class="price text-right">{{ app_number_format($product->price)}}&nbsp;€</td>
    <td class="price text-right">{{ app_number_format($productService->priceTtc($product))}}&nbsp;€</td>
    <td class="quantity text-center">
        <div class="">
            {{--QUENTIN - RETIRÉ LE 11/10/2017 - PROBLEME DE DUPLICATION DE DONNÉES--}}
            {{--{!! Form::number('quantity',--}}
                {{--$line->quantity,--}}
                {{--[--}}
                {{--'id'=> "quantity-$product->id",--}}
                {{--'class' => 'form-control text-center',--}}
                {{--'min' => 0,--}}
                {{--'href' => route(config('hegyd-ecommerce.routes.frontend.cart.update'))--}}
            {{--]) !!}--}}
            <input type="number"
                   name="quantity"
                   class="form-control text-center"
                   value="{{$line->quantity}}"
                   min="0"
                   href="{{route(config('hegyd-ecommerce.routes.frontend.cart.update'))}}"
            >
        </div>
        @if($stock <= 0)
            @lang('hegyd-ecommerce::products.labels.no_more_stock')
        @endif
    </td>
    <td class="price text-right">{{ app_number_format($cartService->totalLinePrice($line)) }}&nbsp;€
    {{--<td>{{ $product->vat->name }}</td>--}}
    {{--<td>{{ app_number_format($cartService->totalLinePrice($line, true)) }}&nbsp;€--}}
    </td>
    <td class="actions">
        <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.remove')) }}"
           class="delete-cart-line"><i class="fa fa-trash"></i></a>
    </td>
</tr>