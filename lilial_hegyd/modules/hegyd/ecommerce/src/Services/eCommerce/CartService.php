<?php namespace Hegyd\eCommerce\Services\eCommerce;


use Hegyd\eCommerce\Exceptions\eCommerce\MissingPaymentMeans;
use Hegyd\eCommerce\Exceptions\eCommerce\PaymentMeansNotFound;
use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\eCommerce\CartLine;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Models\eCommerce\OrderLine;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Services\eCommerce\Payment\PaypalProvider;


class CartService
{

    /**
     * Get current cart
     * By connected user
     * @return mixed
     */
    public function currentCart()
    {
        $repository = app(CartRepositoryInterface::class);
        $current_cart = null;

        if (auth()->check())
        {
            $current_cart = $repository->firstOrCreate([
                'user_id' => auth()->user()->id,
            ]);
            if ( ! $current_cart->payment_means)
            {
                $current_cart->payment_means = Order::PAYMENT_MEANS_PAYPAL;
                $current_cart->save();
            }
        }

        return $current_cart;
    }

    /**
     * Check if cart can be submitted
     * @param Cart $cart
     * @return bool
     */
    public function cartCanBeValidated(Cart $cart)
    {
        $current_user = auth()->user();

        if ( ! $current_user)
            return false;

        if ($this->currentTotalPrice() < $this->getCartMinimumPrice())
            return false;

        if ( ! $cart->invoiceAddress || ! $cart->deliveryAddress)
            return false;


        return true;
    }

    /**
     * Merge two cart
     * @param Cart $master
     * @param Cart $slave
     */
    public function mergeCart(Cart $master, Cart $slave)
    {
        $cartLineRepository = app(CartLineRepositoryInterface::class);
        foreach ($slave->lines as $slave_line)
        {
            $master_line = $master->lines()->where('product_id', $slave_line->product_id)->first();

            if ($master_line)
            {
                $master_line->quantity += $slave_line->quantity;
                $cartLineRepository->reset();
                $cartLineRepository->updateRich($master_line->getAttributes(), $master_line->id);
            } else
            {
                $line = new CartLine();
                $line->cart_id = $master->id;
                $line->product_id = $slave_line->product_id;
                $line->quantity = $slave_line->quantity;
                $cartLineRepository->reset();
                $cartLineRepository->save($line->getAttributes());
            }
        }

        app(CartRepositoryInterface::class)->delete($slave->id);
    }

    /**
     * Convert current cart to order
     */
    public function convertCurrentCartToOrder()
    {
        $this->convertCartToOrder($this->currentCart());
    }

    /**
     * Convert cart to order
     * @param Cart $cart
     * @return Order
     */
    public function convertCartToOrder(Cart $cart)
    {
        $orderRepository = app(OrderRepositoryInterface::class);
        $orderLineRepository = app(OrderLineRepositoryInterface::class);

        $user = $cart->user;
        $order = new Order();

        $order->status = Order::STATUS_WAITING_FOR_PAYMENT;
        $order->reference = date('ymd') . '_' . sprintf("%'.05d", $user->id) . '_' . sprintf("%'.03d", $user->orders->count() + 1);

        $delivery_address = $cart->deliveryAddress;
        $invoice_address = $cart->invoiceAddress;

        $order->delivery_firstname = $delivery_address->firstname;
        $order->delivery_lastname = $delivery_address->lastname;
        $order->delivery_company = $delivery_address->company;
        $order->delivery_address = $delivery_address->address;
        $order->delivery_additional_1 = $delivery_address->additional_1;
        $order->delivery_additional_2 = $delivery_address->additional_2;
        $order->delivery_city = $delivery_address->city;
        $order->delivery_zip = $delivery_address->zip;
        $order->delivery_country = $delivery_address->country ? $delivery_address->country->title_fr : '';
        $order->delivery_phone = $delivery_address->phone;
        $order->delivery_email = $delivery_address->email;

        $order->invoice_firstname = $invoice_address->firstname;;
        $order->invoice_lastname = $invoice_address->lastname;;
        $order->invoice_company = $invoice_address->company;
        $order->invoice_address = $invoice_address->address;
        $order->invoice_additional_1 = $invoice_address->additional_1;
        $order->invoice_additional_2 = $invoice_address->additional_2;
        $order->invoice_city = $invoice_address->city;
        $order->invoice_zip = $invoice_address->zip;
        $order->invoice_country = $invoice_address->country ? $invoice_address->country->title_fr : '';
        $order->invoice_phone = $invoice_address->phone;
        $order->invoice_email = $invoice_address->email;

        $order->weight_total = $cart->weight();

        $order->product_total_ht = $this->totalLinesPrice($cart);

        $order->delivery_price = $this->deliveryPrice($cart);

        $order->total_ht = $this->totalPrice($cart);

        $order->product_total_ttc = $this->totalLinesPrice($cart, true);
        $order->total_vat = $this->vatPrice($cart);
        $order->total_ttc = $this->totalPrice($cart, true);

        $order->comment = $cart->comment;

        $order->payment_means = $cart->payment_means;

        $order->user_id = $user->id;

        $orderRepository->saveModel($order->getAttributes());
        $order = $orderRepository->getModel();

        foreach ($cart->lines as $line)
        {
            // Init order line
            $orderLine = new OrderLine();
            $orderLine->quantity = $line->quantity;

            // Init Product for flat data
            $product = $line->product;
            $orderLine->product_id = $product->id;
            $orderLine->product_name = $product->name;
            $orderLine->product_reference = $product->reference;
            $orderLine->unit_weight = $product->weight;

            $orderLine->unit_price_ht = $product->price;

            $orderLine->total_ht = $this->totalLinePrice($line);
            $orderLine->total_ttc = $this->totalLinePrice($line, true);

            $orderLine->vat_rate = $product->vat->rate;
            $orderLine->vat_amount = $orderLine->total_ttc - $orderLine->total_ht;

            $orderLine->order_id = $order->id;

            $orderLineRepository->reset();
            $orderLineRepository->saveModel($orderLine->getAttributes());
        }

        $order = $order->fresh();

        return $order;
    }

    /**
     * Calculate the cart line total price
     * @param CartLine $cartLine
     * @param bool $ttc
     * @return string
     */
    public function totalLinePrice(CartLine $cartLine, $ttc = false)
    {

        $price = $cartLine->product ? $cartLine->product->price : 0;

        if ($ttc)
        {
            $coef = (1 + ($cartLine->product->vat->rate / 100));
            $price = $price * $coef;
        }

        $price = $price * $cartLine->quantity;

        return $price;
    }

    /**
     * @return int|string
     */
    public function currentVatPrice()
    {
        $cart = $this->currentCart();

        return $this->vatPrice($cart);
    }

    /**
     * @param Cart $cart
     */
    public function vatPrice(Cart $cart)
    {
        return $this->totalPrice($cart, true) - $this->totalPrice($cart);
    }

    /**
     * @param bool $ttc
     */
    public function totalLinesPrice(Cart $cart, $ttc = false)
    {
        $price = 0;

        foreach ($cart->lines as $line)
        {
            $price += $this->totalLinePrice($line, $ttc);
        }

        return $price;
    }

    /**
     * @param bool $ttc
     */
    public function currentTotalLinesPrice($ttc = false)
    {
        return $this->totalLinesPrice($this->currentCart(), $ttc);
    }

    /**
     * @param Cart $car
     * @return int
     */
    public function deliveryPrice(Cart $cart, $ttc = false)
    {
        $deliveryPrice = 0;

        foreach ($cart->lines as $line)
        {
            $deliveryPrice += $line->product->delivery_price * $line->quantity;
        }

        if ($ttc)
        {
            $coef = (1 + (20 / 100));
            $deliveryPrice = $deliveryPrice * $coef;
        }


        return $deliveryPrice;
    }

    public function currentDeliveryPrice()
    {
        return $this->deliveryPrice($this->currentCart());
    }

    /**
     * @param Cart $cart
     * @param bool $ttc
     * @return int|string
     */
    public function totalPrice(Cart $cart, $ttc = false)
    {
        $price = 0;

        $price += $this->totalLinesPrice($cart, $ttc);
        $price += $this->deliveryPrice($cart, $ttc);

        return $price;
    }

    /**
     * @param bool $ttc
     */
    public function currentTotalPrice($ttc = false)
    {
        $price = $this->totalPrice($this->currentCart(), $ttc);

        return $price;
    }

    public function getCartMinimumPrice()
    {
        return config('hegyd-ecommece.cart.minimum_price', 0);
    }

    public function getPaymentProvider($cart)
    {
        if ( ! $cart->payment_means)
            throw new MissingPaymentMeans();

        $class = '';

        if ($cart->payment_means == Order::PAYMENT_MEANS_PAYPAL)
            $class = config('hegyd-ecommerce.payments.paypal.provider');

        if ( ! $class)
            throw new PaymentMeansNotFound();

        return app($class);
    }
}