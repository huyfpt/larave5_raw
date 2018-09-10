<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\eCommerce\CartLine;
use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class CartLineRepository extends Repository implements CartLineRepositoryInterface
{

    public function model()
    {
        return CartLine::class;
    }

    public function findByCartProduct(Cart $cart, Product $product, $orNew = true)
    {
        $attributes = [
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
        ];

        if ($orNew)
        {
            return CartLine::firstOrNew($attributes);
        } else
        {
            return CartLine::where($attributes)->first();
        }
    }

    public function findByProduct(Product $product, $excluded_ids = [])
    {
        return CartLine::where('product_id', $product->id)
            ->whereNotIn('id', $excluded_ids)
            ->get();
    }
}