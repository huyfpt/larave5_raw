<?php namespace Hegyd\eCommerce\Http\ViewComposers;


use Hegyd\eCommerce\Services\eCommerce\CartService;
use Illuminate\View\View;

class CartComposer
{

    public function compose(View $view)
    {
        $view->with('cart', app(CartService::class)->currentCart());
    }

}