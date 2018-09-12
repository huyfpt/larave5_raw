<?php namespace Hegyd\Plans\Controllers\Backend;


use Hegyd\Plans\Models\PlansCategory;
use Hegyd\Plans\Repositories\Contracts\PlansCategoryRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class PlansCategoriesController
 * @package Hegyd\Plans\Controllers\Backend
 */
class PlansCategoriesController extends AbstractBackendController
{

    use Uploadable;

    public function __construct(Request $request, PlansCategoryRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-plans.tables.plans_category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-plans.routes.backend.prefix.plans_category'),
                'lang'  => 'hegyd-plans::plans_categories.',
                'view'  => 'hegyd-plans::backend.categories.',
                'acl'   => config('hegyd-plans.permissions.prefix.backend.plans_category'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'name',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.name',
            ],
            // the columns configuration
            'columns'          => [
                'name'   => [
                    'title'     => 'hegyd-plans::plans_categories.field.name',
                    'type'      => 'text',
                    'filterKey' => 'name',
                    'route'     => config('hegyd-plans.routes.backend.plans_category.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                    'class_row' => 'text-left',
                ],
                'id'     => [
                    'title'                 => 'hegyd-plans::plans_categories.field.plans',
                    'type'                  => 'text',
                    'callBack'              => 'printCount',
                    'relation'              => 'plans',
                    'relation_route'        => config('hegyd-plans.routes.backend.plans.index'),
                    'relation_route_params' => [
                        'plans___category_id' => 'id'
                    ],
                    'orderable'             => false,
                    'class'                 => 'col-md-1',
                    'class_row'             => 'text-center',
                ],
                'active' => [
                    'title'     => 'hegyd-plans::plans_categories.field.status',
                    'type'      => 'bool',
                    'filterKey' => 'active',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }

    public function configureUploads()
    {
        return [
            'visual' => [
                'type'       => 'image',
                'relation'   => Upload::RELATION_UNIQUE,
                'visibility' => Upload::VISIBILITY_PUBLIC,
            ]
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.plans',
            'route'          => config('hegyd-plans.routes.backend.plans.index'),
            'complete_route' => true,
            'class'          => 'btn-danger',
            'icon_class'     => 'fa fa-list',
        ];

        return parent::index();
    }

    public function createFromModal()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }

        $category = new PlansCategory();

        $this->validate($this->getRequest(), [
            'name' => 'required|unique:' . config('hegyd-plans.tables.plans_category') . ',name|max:50',
        ]);

        $datas = $this->beforeSave($this->getRequest()->all(), $category);

        $category->fill($datas);

        $this->repository->save($category->getAttributes());

        $model = $this->repository->getModel();

        return $this->successJsonResponse(200, ['entity' => $model]);
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

    public function destroy($id)
    {
        // PlansCategory::deletePlans($id);
        return $this->executeDelete($id);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['categories'] = app(PlansCategoryRepositoryInterface::class)->pluck('name', 'id');

        $vars['categories'][0] = 'Root';
        ksort($vars['categories']);

        $vars['category_selected'] = null;

        $vars['authors'] = app(config('hegyd-plans.services.plans'))->populateAuthor();

        $vars['author_selected'] = auth()->user()->id;

        if ($this->getRequest()->has('category_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('category_id');
        }

        return $vars;
    }

}