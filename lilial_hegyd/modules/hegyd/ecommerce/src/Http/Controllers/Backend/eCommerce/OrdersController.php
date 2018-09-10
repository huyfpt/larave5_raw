<?php namespace Hegyd\eCommerce\Http\Controllers\Backend\eCommerce;


use Hegyd\eCommerce\Http\Controllers\Backend\AbstractBackendController;
use Hegyd\eCommerce\Events\Notifications\eCommerce\NewOrderEvent;
use Hegyd\eCommerce\Jobs\NotifyUsers;
use Hegyd\eCommerce\Mails\eCommerce\OrderCreated;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Services\eCommerce\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends AbstractBackendController
{

    public function __construct(Request $request, OrderRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    public function configure()
    {
        $table = config('hegyd-ecommerce.tables.order');
        $user_table = config('hegyd-ecommerce.tables.user');
        $agency_table = config('hegyd-ecommerce.tables.agency');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-ecommerce.routes.backend.prefix.order'),
                'lang'  => 'hegyd-ecommerce::orders.',
                'view'  => 'hegyd-ecommerce::backend.contents.orders.',
                'acl'   => config('hegyd-ecommerce.permissions.prefix.backend.order'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'reference',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.reference',
                $table . '.total_ht',
                $table . '.total_ttc',
                $table . '.created_at',
                $table . '.status',
                $table . '.user_id',
            ],
            'join'             => [
                [$user_table, "$table.user_id", '=', "$user_table.id"],
            ],
            // the columns configuration
            'columns'          => [
                'reference'  => [
                    'title'     => 'hegyd-ecommerce::orders.fields.reference',
                    'type'      => 'text',
                    'filterKey' => $table . '.reference',
                    'route'     => config('hegyd-ecommerce.routes.backend.order.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                    'class'     => 'col-md-1',
                ],
                'total_ht'   => [
                    'title'     => 'hegyd-ecommerce::orders.fields.total_ht',
                    'type'      => 'text',
                    'filterKey' => $table . '.total_ht',
                    'class'     => 'col-md-1',
                    'callBack'  => 'printPrice',
                ],
                'total_ttc'  => [
                    'title'     => 'hegyd-ecommerce::orders.fields.total_ttc',
                    'type'      => 'text',
                    'filterKey' => $table . '.total_ttc',
                    'class'     => 'col-md-1',
                    'callBack'  => 'printPrice',
                ],
                'user_id'    => [
                    'title'         => 'hegyd-ecommerce::orders.fields.user',
                    'type'          => 'select',
                    'filterKey'     => 'orders.user_id',
                    'listPopulator' => 'populateUsers',
                    'callBack'      => 'printUser',
                    'class'         => 'col-md-2',
                ],
                'created_at' => [
                    'title'      => 'hegyd-ecommerce::orders.fields.created_at',
                    'type'       => 'date',
                    'filterKey'  => 'orders.created_at',
                    'class'      => 'col-md-1',
                    'callBack'   => 'printDate',
                    'dateFormat' => 'd/m/Y H:i',
                ],
                'status'     => [
                    'title'         => 'hegyd-ecommerce::orders.fields.status',
                    'type'          => 'select',
                    'filterKey'     => 'orders.status',
                    'class'         => 'col-md-1',
                    'listPopulator' => 'populateStatus',
                    'callBack'      => 'printStatus',
                ],
            ],
        ];
    }


    public function index()
    {
        $this->_where[] = ['orders.status', '<', Order::STATUS_ARCHIVED];
        $this->moreActions[] = [
            'acl'        => 'archived',
            'label'      => 'buttons.archived',
            'route'      => 'archived',
            'class'      => 'btn-primary',
            'icon_class' => 'fa fa-archive',
        ];

        return parent::index();
    }

    public function archived()
    {
        $this->_where[] = ['orders.status', '=', Order::STATUS_ARCHIVED];
        $this->title = $this->trans('title.archived');

        $this->moreActions[] = [
            'acl'        => 'access',
            'label'      => 'buttons.not-archived',
            'route'      => 'index',
            'class'      => 'btn-primary',
            'icon_class' => 'fa fa-envelope',
        ];

        if ( ! $this->acl('archived'))
        {
            abort(401);
        }

        if ($this->getRequest()->ajax())
        {
            return $this->ajaxIndex();
        } else
        {
            $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
            $this->breadcrumbs->addCrumb($this->trans('title.management'), route($this->routeAlias('index')));
            $this->breadcrumbs->addCrumb($this->trans('title.archived'));
        }

        return $this->displayView();
    }

    public function update($id)
    {
        $this->model = $this->getRepository()->findOrFail($id);

        if ($this->model->status >= Order::STATUS_ARCHIVED)
            abort(401);

        return parent::update($id);
    }

    /**
     * @param $id
     */
    public function downloadInvoice($id)
    {
        $order = $this->repository->findOrFail($id);
        $title = trans('orders.labels.invoice_name', ['reference' => $order->reference]);

        if ( ! auth()->user()->hasRole(['superadmin', 'admin', 'commercial']) && auth()->user()->id != $order->user_id)
            abort(404);

        $pdf = app(OrderService::class)->generateInvoice($order);

        return $pdf->stream($title);
    }

    /**
     * @return array
     */
    protected function populateStatus()
    {
        $status = [];

        foreach (Order::$status as $value => $name)
        {
            $status[$value] = trans("hegyd-ecommerce::$name");
        }

        return $status;
    }

    protected function printStatus($field, $value, $id)
    {
        return view('hegyd-ecommerce::backend.contents.orders.includes.row.status')
            ->with('value', $value)
            ->render();
    }

    public function populateUsers()
    {

        $users = $this->repository->users();
        $return = [];

        foreach ($users as $user)
        {
            $value = $user->fullname(true);

            $return[$user->id] = $value;
        }

        return $return;
    }

    public function printUser($field, $value, $id)
    {
        $user = app(config('hegyd-ecommerce.repositories.user'))->find($value);
        if ($user)
        {
            $value = $user->fullname(true);

            return view('hegyd-ecommerce::backend.includes.datatable.link')
                ->with('route', route(config('hegyd-ecommerce.routes.backend.user.edit'), $user->id))
                ->with('value', $value)
                ->render();
        }
    }

    protected function exportFields()
    {
        return [
            'reference',
            'status',
            'created_at',
            'user',
            'total_ht',
            'commercial',
            'site',
            'comment',
        ];
    }

    public function exportExcel()
    {
        $this->_where[] = ['orders.id', 'IN', explode(',', $this->getRequest()->get('ids'))];

        return parent::exportExcel();
    }

    /**
     * Export rows
     *
     * @return array
     */
    protected function exportRows()
    {
        $this->applyJoin();
        $this->applyWhere();
        $recordsTotal = $this->getRepository()->count();
        $this->applyWith();
        $this->getRepository()->applyWhere($this->_where, $this->_or);
        $this->initRows();
        $objects = $this->getRepository()->findWhere($this->_where, $this->_select);

        $orderService = app(OrderService::class);

        $rows = [];
        foreach ($objects as $object)
        {
            $rows[$object->id] = [];
            $rows[$object->id][] = $object->reference;
            $rows[$object->id][] = $orderService->statusText($object->status);
            $rows[$object->id][] = $object->created_at->format('d/m/Y H:i');
            $rows[$object->id][] = $object->user ? $object->user->fullname : '';
            $rows[$object->id][] = $object->total_ht;
            $rows[$object->id][] = $object->commercial ? $object->commercial->fullname : '';
            $rows[$object->id][] = $object->site ? $object->site->name : '';
            $rows[$object->id][] = $object->comment;
        }

        return $rows;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }
}