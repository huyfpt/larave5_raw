<?php namespace Hegyd\eCommerce\Http\Controllers\Frontend\eCommerce;

use Hegyd\eCommerce\Http\Controllers\AbstractController;
use Hegyd\eCommerce\Http\Controllers\Frontend\AbstractFrontendController;
use Hegyd\eCommerce\Http\Controllers\Traits\Apiable;
use Hegyd\eCommerce\Http\Controllers\Traits\Configurable;
use Hegyd\eCommerce\Http\Controllers\Traits\Datatable;
use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\eCommerce\CartLine;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Services\eCommerce\CartService;
use Hegyd\eCommerce\Services\eCommerce\OrderService;
use Illuminate\Http\Request;

/**
 * Class OrdersController
 * @package Hegyd\eCommerce\Http\Controllers\Frontend\eCommerce
 */
class OrdersController extends AbstractFrontendController
{

    use Apiable, Datatable;

    protected $order_service;

    /**
     * OrderController constructor.
     * @param Request $request
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(Request $request, OrderRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);

        $this->repository = $repository;
        $this->order_service = app(OrderService::class);

        $this->readConfiguration();
        $this->prepareColumns();
    }

    protected function configure()
    {
        $table = config('hegyd-ecommerce.tables.order');

        return [
            'rows_actions_template' => 'includes.datatable.actions',
            // the prefix for the view routing, lang and view
            'prefixes'              => [
                'route' => config('hegyd-ecommerce.routes.frontend.prefix.order'),
                'lang'  => 'hegyd-ecommerce::orders.',
                'view'  => 'hegyd-ecommerce::frontend.contents.orders.',
                'acl'   => config('hegyd-ecommerce.permissions.prefix.frontend.ecommerce'),
            ],
            'views'                 => [
                // the default template for datatable view
                'index'  => 'index',
                // the default template for create view
                'create' => 'form',
                // the default template for update view
                'update' => 'form',
            ],
            // by default the datatable will have the filter bar
            'filter'                => true,
            'join'                  => [],
            'where'                 => [
                'user_id' => auth()->user()->id
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name'      => 'name',
            // the select fields used when retrieving rows
            'select'                => [
                $table . '.id',
                $table . '.reference',
                $table . '.status',
                $table . '.created_at',
                $table . '.payment_means',
                $table . '.total_ttc',
            ],
            // the columns configuration
            'columns'               => [
                'reference'     => [
                    'title'     => 'hegyd-ecommerce::orders.fields.reference',
                    'type'      => 'text',
                    'filterKey' => $table . '.reference',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'created_at'    => [
                    'title'      => 'hegyd-ecommerce::orders.fields.created_at',
                    'type'       => 'date',
                    'callBack'   => 'printDate',
                    'dateFormat' => 'd/m/Y H:i',
                    'filterKey'  => $table . '.created_at',
                    'class_row'  => 'text-center',
                    'class'      => 'col-md-2',
                ],
                'status'        => [
                    'title'         => 'hegyd-ecommerce::orders.fields.status',
                    'type'          => 'text',
                    'filterKey'     => $table . '.status',
                    'class_row'     => 'text-center',
                    'class'         => 'col-md-2',
                    'callBack'      => 'printStatus',
                    'type'          => 'select',
                    'listPopulator' => 'populateStatus',
                ],
                'payment_means' => [
                    'title'          => 'hegyd-ecommerce::orders.fields.payment_means',
                    'type'           => 'text',
                    'filterKey'      => $table . '.payment_means',
                    'class_row'      => 'text-center',
                    'class'          => 'col-md-2',
                    'callBack'       => 'printPaymentMeans',
                    'orderable'      => 'false',
                    'disable_filter' => true,
                ],
                'total_ttc'     => [
                    'title'          => 'hegyd-ecommerce::orders.fields.total_ttc',
                    'type'           => 'text',
                    'filterKey'      => $table . '.total_ttc',
                    'class_row'      => 'text-center',
                    'class'          => 'col-md-2',
                    'callBack'       => 'printPrice',
                    'disable_filter' => true,
                ],
            ],
        ];
    }

    /**
     * Display order details
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $order = $this->repository->findOrFail($id);
        $this->_handleOwner($order);

        $this->breadcrumbs->addCrumb(trans('hegyd-ecommerce::orders.title.my_orders'), route(config('hegyd-ecommerce.routes.frontend.order.index')));
        $title = trans('hegyd-ecommerce::orders.title.show', ['reference' => $order->reference]);
        $this->breadcrumbs->addCrumb($title);

        return view('hegyd-ecommerce::frontend.contents.orders.show', compact('title', 'order'));
    }

    /**
     * @param $id
     */
    public function downloadInvoice($id)
    {
        $order = $this->repository->findOrFail($id);

        $this->_handleOwner($order);

        $title = trans('hegyd-ecommerce::orders.labels.invoice_name', ['reference' => $order->reference]);
        $pdf = app(OrderService::class)->generateInvoice($order);

        return $pdf->stream($title);
    }

    /**
     *  Add to current cart, all allowed product from the order
     * @param $id
     */
    public function reOrder($id)
    {
        $order = $this->repository->findOrFail($id);

        $this->_handleOwner($order);

        $current_user = auth()->user();

        $cart_service = app(CartService::class);

        $current_cart = $cart_service->currentCart();

        $allowed_product_ids = app(ProductRepositoryInterface::class)
            ->active()
            ->pluck('id')
            ->toArray();

        $cart = new Cart();

        foreach ($order->lines as $line)
        {
            if ( ! in_array($line->product_id, $allowed_product_ids) && $line->product->stock)
                continue;

            $quantity = $line->quantity;
            if ($line->product->stock < $line->quantity)
            {
                $quantity = $line->product->stock;
            }

            $cart_line = new CartLine();
            $cart_line->product_id = $line->product_id;
            $cart_line->quantity = $quantity;
            $cart->lines->add($cart_line);
        }

        $cart_service->mergeCart($current_cart, $cart);

        return redirect()->route(config('hegyd-ecommerce.routes.frontend.cart.index'));
    }


    public function populateStatus()
    {
        $datas = [];

        $status = $this->repository->statusByUser(auth()->user());

        foreach ($status as $st)
        {
            $datas[$st] = $this->order_service->statusText($st);
        }

        return $datas;
    }

    public function printStatus($field, $value, $id)
    {
        return $this->order_service->statusText($value);
    }

    public function printPaymentMeans($field, $value, $id)
    {
        return $this->order_service->paymentMeansText($value);
    }

    private function _handleOwner(Order $order)
    {
        if ( ! auth()->user()->hasRole(['superadmin', 'admin']) && auth()->user()->id != $order->user_id)
            abort(404);
    }
}