<?php namespace Hegyd\Plans\Controllers\Backend;

use Carbon\Carbon;
use Hegyd\Plans\Repositories\Contracts\PlansCategoryRepositoryInterface;
use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use App\Http\Controllers\Traits\Addressable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Hegyd\Plans\Models\Plans;

/**
 * Class PlansController
 * @package Hegyd\Plans\Controllers\Backend
 */
class PlansController extends AbstractBackendController
{

    use Addressable, Uploadable;

    public function __construct(Request $request, PlansRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-plans.tables.plans');
        $categories_table = config('hegyd-plans.tables.plans_category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-plans.routes.backend.prefix.plans'),
                'lang'  => 'hegyd-plans::plans.',
                'view'  => 'hegyd-plans::backend.plans.',
                'acl'   => config('hegyd-plans.permissions.prefix.backend.plans'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'title',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.title',
                $table . '.content',
                $table . '.url',
                $table . '.start_at',
                $table . '.end_at',
                $table . '.visibility',
                $table . '.created_at',
                $table . '.category_id',
                $categories_table . '.name as category_name',
                $categories_table . '.active as category_active',
            ],
            'left_join'        => [
                [$categories_table, $table . '.category_id', '=', $categories_table . '.id'],
            ],
            // the columns configuration
            'columns'          => [
                'title'          => [
                    'title'     => 'hegyd-plans::plans.field.title',
                    'type'      => 'text',
                    'filterKey' => $table . '.title',
                    'route'     => config('hegyd-plans.routes.backend.plans.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                    'class'     => 'col-md-4',
                    'class_row' => 'text-left',
                ],
                'category_name' => [
                    'title'         => 'hegyd-plans::plans.field.category',
                    'type'          => 'select',
                    'listPopulator' => 'populateCategories',
                    'filterKey'     => $table . '.category_id',
                    'route'         => config('hegyd-plans.routes.backend.plans_category.edit'),
                    'route_id'      => 'category_id',
                    'callBack'      => 'printLink',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                'visibility'          => [
                    'title'         => 'hegyd-plans::plans.field.visibility',
                    'type'          => 'select',
                    'listPopulator' => 'populateVisible',
                    'filterKey'     => $table . '.visibility',
                    'callBack'      => 'printVisible',
                    'class'         => 'col-md-1',
                    'class_row'     => 'text-center',
                ],
                'created_at'          => [
                    'title'     => 'hegyd-plans::plans.field.created_at',
                    'type'      => 'date',
                    'filterKey' =>  $table . '.created_at',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }
    
    public function configureAddresses()
    {
        return ['address' => []];
    }

    public function configureUploads()
    {
        return [
            'visual' => [
                'type'        => 'image',
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ]
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.categories',
            'route'          => config('hegyd-plans.routes.backend.plans_category.index'),
            'complete_route' => true,
            'class'          => 'btn-danger',
            'icon_class'     => 'fa fa-list',
        ];
        
        return parent::index();
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }

        /*if (isset($datas['start_at']))
        {
            if ($datas['start_at'])
            {
                $datas['start_at'] = Carbon::createFromFormat('d/m/Y', $datas['start_at']);
            } else
            {
                $datas['start_at'] = null;
            }
        }

        if (isset($datas['end_at']))
        {
            if ($datas['end_at'])
            {
                $datas['end_at'] = Carbon::createFromFormat('d/m/Y', $datas['end_at']);
            } else
            {
                $datas['end_at'] = null;
            }
        }*/

        if ( ! $datas['author_id'])
        {
            $datas['author_id'] = auth()->user()->id;
        }

        if ( ! isset($datas['avantage']))
        {
            $datas['avantage'] = false;
        }

        if ( ! isset($datas['visibility']) || $datas['visibility'] == 0)
        {
            $datas['visibility'] = 1;
        }
        else
        {
            $datas['visibility'] = 0;
        }
        // dd($datas);
        return $datas;

    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        return $model;
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['categories'] = app(PlansCategoryRepositoryInterface::class)->pluck('name', 'id');

        $vars['category_selected'] = null;

        $vars['authors'] = app(config('hegyd-plans.services.plans'))->populateAuthor();

        $vars['author_selected'] = auth()->user()->id;

        if ($this->getRequest()->has('category_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('category_id');
        }

        $vars['city_selected'] = null;

        $vars['post_code'] = app(config('hegyd-plans.services.plans'))->populatePostCode();

        return $vars;
    }

    public function populateVisible()
    {
        $visible = ['Privé', 'Public'];
        return $visible;
    }

    public function populateCategories()
    {
        return app(PlansCategoryRepositoryInterface::class)->order('name')->pluck('name', 'id');
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

    public function ajaxPostCode()
    {
        $keyword = $this->getRequest()->get('q');

        return app(config('hegyd-plans.services.plans'))->listPostCode($keyword);
    }
}