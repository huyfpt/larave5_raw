<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class CartRepository extends Repository implements CartRepositoryInterface
{

    public function model()
    {
        return Cart::class;
    }

    public function findByPaymentId($paymentId)
    {
        return Cart::where('payment_id', $paymentId)->first();
    }
}