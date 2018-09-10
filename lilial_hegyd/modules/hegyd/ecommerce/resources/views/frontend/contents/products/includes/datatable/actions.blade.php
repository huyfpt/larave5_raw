<div class="btn-group">
	<span>
		{!! Form::number('quantity', 1, [
		'id'        => 'quantity',
		'class'     => 'form-control fiche-wrap',
		'min'       => 1,
		'step'      => 1,
		]) !!}
	    <a class="btn btn-default btn-panier add-to-cart"
	       data-product-id="{{$object->id}}"
	       href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.add')) }}"
	       title="@lang('hegyd-ecommerce::cart.buttons.add_to_cart')">
	        <span><i class="fa fa-shopping-cart"></i></span>
	    </a>
	</span>

	<a class="btn btn-default"
	   href="{{ route(config('hegyd-ecommerce.routes.frontend.product.show'), $object->id) }}"
	   title="@lang('hegyd-ecommerce::products.buttons.show')">
	    <span><i class="fa fa-eye"></i></span>
	</a>
</div>
