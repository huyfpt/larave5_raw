<?php
/**
 * NewslettersController class
 *
 * @category   NewslettersController
 * @package    Hegyd\Faqs\Controllers\Backend
 * @author     Do Viet Hung <hungdv@dfm-engineering.com>
 * @copyright  2018 Hegyd
 * @license    www.hegyd.com
 * @version    1.0.0
 * @since      Class available since Release 1.0
 */
namespace Hegyd\Faqs\Controllers\Backend;

use Excel;
use Carbon\Carbon;
use Hegyd\Faqs\Repositories\Contracts\NewsletterRepositoryInterface;
use Illuminate\Http\Request;

class NewslettersController extends AbstractBackendController
{

    private $newsletterClass;

    public function __construct(Request $request, NewsletterRepositoryInterface $repository)
    {
        $this->newsletterClass = config('hegyd-faqs.models.newsletters');

        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-faqs.tables.newsletters');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-faqs.routes.backend.prefix.newsletters'),
                'lang'  => 'hegyd-faqs::newsletters.',
                'view'  => 'hegyd-faqs::backend.newsletters.',
                'acl'   => config('hegyd-faqs.permissions.prefix.backend.newsletters'),
            ],
            'select'           => [
                $table . '.id',
                $table . '.first_name',
                $table . '.last_name',
                $table . '.email',
                $table . '.active'
            ],
            // the columns configuration
            'columns'          => [
                'first_name'          => [
                    'title'     => 'hegyd-faqs::newsletters.field.first_name',
                    'type'      => 'text',
                    'filterKey' => $table . '.first_name',
                    'class_row' => 'text-left'
                ],
                'last_name'          => [
                    'title'     => 'hegyd-faqs::newsletters.field.last_name',
                    'type'      => 'text',
                    'filterKey' => $table . '.last_name',
                    'class_row' => 'text-left'
                ],
                'email'          => [
                    'title'     => 'hegyd-faqs::newsletters.field.email',
                    'type'      => 'text',
                    'filterKey' => $table . '.email',
                    'class_row' => 'text-left'
                ],
                
                'active'        => [
                    'title'     => 'hegyd-faqs::newsletters.field.active',
                    'type'      => 'bool',
                    'filterKey' => $table . '.active',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.export_csv',
            'route'          => config('hegyd-faqs.routes.backend.newsletters.export-csv'),
            'complete_route' => true,
            'class'          => 'btn-info',
            'icon_class'     => 'fa fa-list',
        ];
        $this->moreActions[] = [
            'label'          => 'button.export_excel',
            'route'          => config('hegyd-faqs.routes.backend.newsletters.export-excel'),
            'complete_route' => true,
            'class'          => 'btn-info',
            'icon_class'     => 'fa fa-list',
        ];
        if ( ! $this->acl('index'))
        {
            abort(401);
        }

        if ($this->getRequest()->ajax())
        {
            return $this->ajaxIndex();
        } else
        {
            $this->createBreadCrumb();
        }
        return $this->displayView(); 
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }

        return $datas;
    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);
        
        // $role_ids = $this->getRequest()->get('role_ids', []);
        // $model->roles()->sync($role_ids);

        return $model;
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        return $vars;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

    /**
     * Export newsletters to excel file.
     * @param Request $request
     */
    public function exportExcel(Request $request)
    {
        Excel::create('newsletters-export', function ($excel) use ($request)
        {
            $excel->sheet('Newsletters', function ($sheet) use ($request)
            {
                $newsletters = $this->getItemsWithFilters($request)->all();

                $sheet->loadView('hegyd-faqs::backend.newsletters.excel.template', ['newsletters' => $newsletters]);
            });
        })->download('xls');
    }

    /**
     * Export newsletter en fichier CSV
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function exportcsv(Request $request)
    {
        $newsletters = $this->getItemsWithFilters($request)->all();
        $handle = fopen('php://memory', 'r+');
        $header = array(
            utf8_decode(trans('hegyd-faqs::newsletters.field.first_name')),
            utf8_decode(trans('hegyd-faqs::newsletters.field.last_name')),
            utf8_decode(trans('hegyd-faqs::newsletters.field.email')),
            utf8_decode(trans('hegyd-faqs::newsletters.field.active')),
            utf8_decode(trans('hegyd-faqs::newsletters.field.updated_at'))
        );

        fputcsv($handle, $header, ';');
        foreach ($newsletters as $newsletter)
        {
            $data = [];
            $data[] = $newsletter->first_name ? $newsletter->first_name : '';
            $data[] = $newsletter->last_name ? $newsletter->last_name : '';
            $data[] = $newsletter->email ? $newsletter->email : '';
            $data[] = $newsletter->active ? $newsletter->active : '';

            $data[] = date('d/m/Y', strtotime($newsletter->created_at));

            fputcsv($handle, $data, ';');
        }
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        $file_name = 'newsletters-export-'. date("Y-m-d") . '.csv';
        return response($content, 200, array(
            'Content-Type'        => 'application/force-download',
            'Content-Disposition' => "attachment; filename=\"$file_name\""
        ));
    }

    /**
     * get newsletters data for export
     * @param $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getItemsWithFilters(Request $request)
    {
        $class = $this->newsletterClass;
        $newsletters = $class::all();

        return $newsletters;
    }

    /**
     * use all configuration variables and datas to display the view
     * use the template defined by config[view] or defaults[view]
     * @param string $title
     * @param object $model
     * @param string $route
     * @param string $method
     * @return Response
     */
    protected function displayView()
    {
        $title = $this->title;
        if ( ! isset($title) || ! $title)
        {
            $title = $this->trans('title.management');
        }

        // we gets the view
        $view = $this->view('/hegyd-faqs::backend.newsletters.includes.datatable.default_index', compact('title'));

        // we gets the variables to inject into the view
        $vars = $this->viewVars();
        if ( ! empty($vars))
        {
            foreach ($vars as $name => $value)
            {
                $view->with($name, $value);
            }
        }
        $view->with('filter', $this->_filter);
        $view->with('config', $this->_config);
        $view->with('bulkActions', $this->bulkActions);
        $view->with('addButton', $this->addButton);
        $view->with('moreActions', $this->moreActions);


        return $view;
    }

    /**
     * Fill the breadcrumbs created in AbstractAppController
     * with the use of the instance of Breadcrumb defined by the Trait Breadcrumbable
     * @use creitive/laravel5-breadcrumbs vendor
     */
    protected function createBreadCrumb()
    {
        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $this->breadcrumbs->addCrumb(trans('hegyd-faqs::newsletters.newsletters.index'), route(config('hegyd-faqs.routes.backend.newsletters.index')));
        $title = $this->title;
        if ( ! isset($title) || ! $title)
        {
            $title = $this->trans('title.management');
        }

        $this->breadcrumbs->addCrumb($title, $this->route('index'));
    }
}