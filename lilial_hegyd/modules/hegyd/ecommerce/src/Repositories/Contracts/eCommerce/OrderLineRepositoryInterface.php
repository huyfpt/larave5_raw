<?php namespace Hegyd\eCommerce\Repositories\Contracts\eCommerce;

use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Models\ProductCatalog\Product;

interface OrderLineRepositoryInterface
{

    public function findByOrderProduct(Order $order, Product $product, $orNew = true);
}