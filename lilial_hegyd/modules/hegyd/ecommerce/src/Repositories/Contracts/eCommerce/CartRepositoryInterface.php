<?php namespace Hegyd\eCommerce\Repositories\Contracts\eCommerce;


interface CartRepositoryInterface
{

    public function findByPaymentId($paymentId);
}