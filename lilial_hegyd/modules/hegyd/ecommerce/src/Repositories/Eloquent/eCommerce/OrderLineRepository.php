<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Models\eCommerce\OrderLine;
use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class OrderLineRepository extends Repository implements OrderLineRepositoryInterface
{

    public function model()
    {
        return OrderLine::class;
    }

    public function findByOrderProduct(Order $order, Product $product, $orNew = true)
    {
        $attributes = [
            'order_id'   => $order->id,
            'product_id' => $product->id,
        ];

        if ($orNew)
        {
            return OrderLine::firstOrNew($attributes);
        } else
        {
            return OrderLine::where($attributes)->first();
        }
    }
}