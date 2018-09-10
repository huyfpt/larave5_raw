<?php namespace Hegyd\Seos\Controllers\Backend;

use App\Http\Controllers\Traits\Apiable;
use Hegyd\Seos\Controllers\AbstractController;
use Hegyd\Seos\Controllers\Traits\Configurable;
use Hegyd\Seos\Controllers\Traits\Datatable;
use Hegyd\Seos\Controllers\Traits\Formable;
use Hegyd\Seos\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class AbstractBackendController
 * @package Hegyd\Seos\Controllers\Backend
 */
abstract class AbstractBackendController extends AbstractController
{

    /**
     * use App\Http\Controllers\Traits\Apiable for Common Json Response
     */
    use Configurable, Datatable, Formable, Apiable
    {
        Datatable::viewVars insteadof Configurable;
        Datatable::createBreadCrumb as DatatableCreateBreadCrumb;
    }

    /**
     *
     * @param Request $request
     * @param RepositoryInterface $repository
     */
    public function __construct(Request $request, RepositoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
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
            'rows_actions_template'  => '/hegyd-seos::backend.includes.datatable.default_actions',

            // use / for indicate to the Configurable Trait that this path don't need to be prefixed with prefixes['view']
            'rows_checkbox_template' => '/hegyd-seos::backend.includes.datatable.default_checkbox',

            // by default the datatable will have the filter bar
            'filter'                 => true,
            'where'                  => [],
            'join'                   => [],
            'views'                  => [
                // the default template for datatable view
                'index'  => '/hegyd-seos::backend.includes.datatable.default_index',
                // the default template for create view
                'create' => 'form',
                // the default template for update view
                'update' => 'form',
            ],
            'bulk'                   => [
                'excel'    => [
                    'route' => 'export.excel',
                    'icon'  => 'fa fa-download',
                    'text'  => trans('app.export_excel'),
                    'ajax'  => false,
                ],
                'active'   => [
                    'route' => 'bulk.active',
                    'icon'  => 'fa fa-check',
                    'text'  => trans('app.activate'),
                ],
                'unactive' => [
                    'route' => 'bulk.unactive',
                    'icon'  => 'fa fa-times',
                    'text'  => trans('app.disactivate'),
                ],
                'delete'   => [
                    'route'   => 'bulk.delete',
                    'icon'    => 'fa fa-trash',
                    'text'    => trans('app.delete'),
                    'divider' => true,
                    'confirm' => true,
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
        $config['namespace'] = config('hegyd-seos.view-namespace.backend');

        return $config;
    }

    /**
     * Fill the breadcrumbs created in AbstractAppController
     * with the use of the instance of Breadcrumb defined by the Trait Breadcrumbable
     * @use creitive/laravel5-breadcrumbs vendor
     */
    protected function createBreadCrumb()
    {
        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        // $this->breadcrumbs->addCrumb(trans('hegyd-seos::seos.title.index'));
        $title = $this->title;
        if ( ! isset($title) || ! $title)
        {
            $title = $this->trans('title.management');
        }

        $this->breadcrumbs->addCrumb($title, $this->route('index'));
    }

    /**
     * For the edit view or the create view
     * Fill the breadcrumbs created in AbstractAppController
     * with the use of the instance of Breadcrumb defined by the Trait Breadcrumbable
     * @param String $title : the view title
     * @param BaseModel $model
     * @use creitive/laravel5-breadcrumbs vendor
     */
    protected function createFormBreadCrumb($title, $model = null)
    {
        $this->createBreadCrumb();
        $this->breadcrumbs->addCrumb($title);
    }

    protected function getNotificationService()
    {
        return $this->notificationService;
    }

    protected function getRepository()
    {
        return $this->repository;
    }
}