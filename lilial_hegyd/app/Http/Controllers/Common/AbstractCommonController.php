<?php namespace App\Http\Controllers\Common;


use App\Http\Controllers\AbstractAppController;
use App\Http\Controllers\Traits\Apiable;
use App\Http\Controllers\Traits\Configurable;
use App\Http\Controllers\Traits\Datatable;
use App\Http\Controllers\Traits\Formable;
use Illuminate\Http\Request;

abstract class AbstractCommonController extends AbstractAppController
{

    /**
     * use App\Http\Controllers\Traits\Apiable for Common Json Response
     */
    use Apiable, Configurable, Datatable, Formable
    {
        Datatable::viewVars insteadof Configurable;
        Datatable::createBreadCrumb as DatatableCreateBreadCrumb;
    }

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->createConfiguration();
        $this->readConfiguration();
        $this->prepareColumns();
    }

    /**
     * Create the default configuration for the Configurable abstract controller
     * @returns array
     */
    protected function defaults()
    {
        return [
            // use / for indicate to the Configurable Trait that this path don't need to be prefixed with prefixes['view']
            'rows_actions_template'  => '/app.includes.datatable.default_actions',

            // use / for indicate to the Configurable Trait that this path don't need to be prefixed with prefixes['view']
            'rows_checkbox_template' => '/app.includes.datatable.default_checkbox',

            // by default the datatable will have the filter bar
            'filter'                 => true,
            'where'                  => [],
            'join'                   => [],
            'views'                  => [
                // the default template for datatable view
                'index'  => '/app.includes.datatable.default_index',
                // the default template for create view
                'create' => 'form',
                // the default template for update view
                'update' => 'form',
            ],
            'bulk'                   => [
                'excel'    => [
                    'route' => 'export.excel',
                    'icon'  => 'fas fa-download',
                    'text'  => trans('app.export_excel'),
                    'ajax'  => false,
                ],
                'active'   => [
                    'route' => 'bulk.active',
                    'icon'  => 'fas fa-check',
                    'text'  => trans('app.activate'),
                ],
                'unactive' => [
                    'route'         => 'bulk.unactive',
                    'icon'          => 'fas fa-times',
                    'text'          => trans('app.disactivate'),
                    'confirm'       => true,
                    'confirm-title' => trans('app.confirms.bulk.unactive.title'),
                    'confirm-text'  => trans('app.confirms.bulk.unactive.text'),
                ],
                'delete'   => [
                    'route'         => 'bulk.delete',
                    'icon'          => 'fas fa-trash',
                    'text'          => trans('app.delete'),
                    'divider'       => true,
                    'confirm'       => true,
                    'confirm-title' => trans('app.confirms.bulk.delete.title'),
                    'confirm-text'  => trans('app.confirms.bulk.delete.text'),
                ],
            ],
        ];
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        $config = parent::configureBreadcrumb();
        $config['namespace'] = 'app';

        return $config;
    }
}