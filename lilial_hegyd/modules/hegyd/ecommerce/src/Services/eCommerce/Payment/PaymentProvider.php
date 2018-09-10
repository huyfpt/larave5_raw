<?php namespace Hegyd\eCommerce\Services\eCommerce\Payment;

interface PaymentProvider
{

    /**
     * @param $cart
     * @return mixed
     */
    public function processPayment($cart);

    /**
     * @param $cart
     * @param $request
     * @return mixed
     */
    public function validatePayment($cart, $request);
}