<?php namespace Hegyd\eCommerce\Services\eCommerce;

use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Models\eCommerce\OrderLine;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Services\ProductCatalog\ProductService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Collection;

class OrderService
{

    public function statusText($status)
    {
        if (isset(Order::$status[$status]))
        {
            return trans("hegyd-ecommerce::".Order::$status[$status]);
        }

        return trans('app.unknown');
    }


    public function status()
    {
        $status = [];
        foreach (Order::$status as $key => $st)
        {
            $status[$key] = trans("hegyd-ecommerce::$st");
        }

        return $status;
    }

    public function paymentMeansText($payment_means)
    {
        if (isset(Order::$payment_means[$payment_means]))
        {
            return trans('hegyd-ecommerce::' . Order::$payment_means[$payment_means]);
        }

        return trans('app.unknown');
    }

    /**
     * @param Order $order
     * @param OrderLine $order_line
     * @param $quantity
     */
    public function addOrUpdateOrderLine(Order $order, OrderLine $order_line, $quantity, $forceAdd = false)
    {
        $orderLineRepository = app(OrderLineRepositoryInterface::class);

        if ($quantity <= 0)
            $quantity = 1;

        if ( ! $order_line->exists)
        {
            $order_line->product_reference = $order_line->product->reference;
            $order_line->product_name = $order_line->product->name;
            $order_line->quantity = $quantity;

            $best_price = app(ProductService::class)->bestPrice($order_line->product, $order->site, $order->user);
            $price = $best_price->price;
            if ($best_price->price_promo)
            {
                $price = $best_price->price_promo;
            }

            $order_line->unit_price_ht = $price;
            $order_line->vat_rate = $order_line->product->vat->rate;
        } else
        {
            if ($forceAdd)
            {
                $order_line->quantity += $quantity;
            } else
            {
                $order_line->quantity = $quantity;
            }
        }

        $total_price_ht = $order_line->unit_price_ht * $quantity;
        $total_price_ttc = $total_price_ht * (1 + ($order_line->vat_rate / 100));
        $vat_amount = $total_price_ttc - $total_price_ht;

        $order_line->total_ht = $total_price_ht;
        $order_line->total_ttc = $total_price_ttc;
        $order_line->vat_amount = $vat_amount;

        $orderLineRepository->setMyModel($order_line);
        $orderLineRepository->save($order_line->getAttributes());

        $this->recalculateOrder($order);
    }

    /**
     * @param Order $order
     * @param OrderLine $order_line
     */
    public function removeOrderLine(Order $order, OrderLine $order_line)
    {
        $orderLineRepository = app(OrderLineRepositoryInterface::class);

        $errors = [];
        if ($orderLineRepository->checkDelete($order_line, $errors))
        {
            $orderLineRepository->delete($order_line->id);
        }

        $this->recalculateOrder($order);
    }

    /**
     * @param Cart $cart
     * @return int
     */
    public function deliveryPrice(Order $order)
    {
        return 0;
    }

    /**
     * @param Order $order
     */
    public function recalculateOrder(Order $order)
    {
        $order_total_ht = 0;
        $order_total_vat = 0;
        $order_total_ttc = 0;

        foreach ($order->lines as $line)
        {
            $order_total_ht += $line->total_ht;
            $order_total_vat += $line->vat_amount;
            $order_total_ttc += $line->total_ttc;
        }

        $order->product_total_ht = $order_total_ht;
        $order->product_total_ttc = $order_total_ttc;

        $delivery_price = $this->deliveryPrice($order);
        $order->delivery_price = $delivery_price;

        $order_total_ttc += $delivery_price;

        $order->total_ht = $order_total_ht;
        $order->total_vat = $order_total_vat;
        $order->total_ttc = $order_total_ttc;

        $orderRepository = app(OrderRepositoryInterface::class);
        $orderRepository->setMyModel($order);
        $orderRepository->save($order->getAttributes());
    }

    public function currentOrders()
    {
        $orders = new Collection();

        $current_site = Front::currentSite();
        $current_user = auth()->user();

        if ( ! $current_site || ! $current_user)
            return $orders;


        $orders = $current_user->orders()->where('site_id', $current_site->id)->orderBy('created_at')->get();

        return $orders;
    }


    public function countOnGoing()
    {
        $site = Admin::currentSite();

        return app(OrderRepositoryInterface::class)->countOnGoing($site);
    }


    public function countBeforeValidated()
    {
        $site = Admin::currentSite();

        return app(OrderRepositoryInterface::class)->countBeforeValidated($site);
    }

    public function generateInvoice(Order $order)
    {
        $title = trans('hegyd-ecommerce::orders.labels.invoice_name', ['reference' => $order->reference]);

        $datas = [
            'order' => $order,
            'title' => $title,
        ];

        $pdf = PDF::loadView('hegyd-ecommerce::pdf.contents.orders.invoice', $datas);

        return $pdf;
    }


    public function decrementStock(Order $order)
    {
        foreach ($order->lines as $line)
        {
            $product = $line->product;

            if ( ! $product)
                continue;

            $product->stock = $product->stock - $line->quantity;
            $product->save();
        }
    }
}