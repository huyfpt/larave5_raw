<?php namespace Hegyd\eCommerce\Repositories\Contracts\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\ProductCatalog\Product;

interface CartLineRepositoryInterface
{

    public function findByCartProduct(Cart $cart, Product $product, $orNew = true);

    public function findByProduct(Product $product, $excluded_ids = []);
}