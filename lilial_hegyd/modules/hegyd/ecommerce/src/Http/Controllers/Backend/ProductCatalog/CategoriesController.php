<?php namespace Hegyd\eCommerce\Http\Controllers\Backend\ProductCatalog;


use Hegyd\eCommerce\Http\Controllers\Backend\AbstractBackendController;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoriesController extends AbstractBackendController
{
    public $repository;
    use Uploadable;
    public static $_id;

    public function __construct(Request $request, CategoryRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
        $this->$repository = $repository;
    }

    public function configure()
    {
        $table = config('hegyd-ecommerce.tables.category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-ecommerce.routes.backend.prefix.category'),
                'lang'  => 'hegyd-ecommerce::categories.',
                'view'  => 'hegyd-ecommerce::backend.contents.categories.',
                'acl'   => config('hegyd-ecommerce.permissions.prefix.backend.category'),
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
                    'title'     => 'hegyd-ecommerce::categories.fields.name',
                    'type'      => 'text',
                    'filterKey' => 'name',
                    'class_row' => 'text-left',
                ],
                'ranking'     => [
                    'title'     => 'hegyd-ecommerce::categories.fields.ranking',
                    'type'      => 'integer',
                    'filterKey' => 'ranking',
                    'orderable' => true,
                    'class'     => 'col-md-1',
                ],
                'active' => [
                    'title'     => 'hegyd-ecommerce::categories.fields.active',
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

    protected function defaults()
    {
        return [
            // use / for indicate to the Configurable Trait that this path don't need to be prefixed with prefixes['view']
            'rows_actions_template'  => '/hegyd-ecommerce::backend.includes.datatable.default_actions',

            // use / for indicate to the Configurable Trait that this path don't need to be prefixed with prefixes['view']
            'rows_checkbox_template' => '/hegyd-ecommerce::backend.includes.datatable.default_checkbox',

            // by default the datatable will have the filter bar
            'filter'                 => true,
            'where'                  => [],
            'join'                   => [],
            'views'                  => [
                // the default template for datatable view
                'index'  => '/hegyd-ecommerce::backend.contents.categories.tree',
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
                    'route'         => 'bulk.unactive',
                    'icon'          => 'fa fa-times',
                    'text'          => trans('app.disactivate'),
                    'confirm'       => true,
                    'confirm-title' => trans('app.confirms.bulk.unactive.title'),
                    'confirm-text'  => trans('app.confirms.bulk.unactive.text'),
                ],
                'delete'   => [
                    'route'         => 'bulk.delete',
                    'icon'          => 'fa fa-trash',
                    'text'          => trans('app.delete'),
                    'divider'       => true,
                    'confirm'       => true,
                    'confirm-title' => trans('app.confirms.bulk.delete.title'),
                    'confirm-text'  => trans('app.confirms.bulk.delete.text'),
                ],
            ],
        ];
    }

    public function createFromModal()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }

        $category = app(config('hegyd-ecommerce.models.category'));

        $this->validate($this->getRequest(), [
            'name' => 'required|unique:' . config('hegyd-ecommerce.tables.category') . ',name|max:50',
        ]);

        $datas = $this->beforeSave($this->getRequest()->all(), $category);

        $category->fill($datas);

        $this->repository->save($category->getAttributes());

        $model = $this->repository->getModel();

        return $this->successJsonResponse(200, ['entity' => $model]);
    }


    public function destroy($id)
    {
        if ( ! $this->acl('delete'))
        {
            abort(401);
        }

        $category = $this->repository->findOrFail($id);

        if ($category->canDelete())
        {
            $category->delete();

            return response()->json();
        }
        
        return response()->json(['error' => __('hegyd-ecommerce::categories.messages.cannot_delete')]);
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas, $model);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }

        return $datas;
    }

    public function edit($id)
    {
        $this->_id = $id;

        return parent::edit($id);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['tree_category'] = $this->$repository->getParentTree($this->_id);

        $vars['parent_id'] = null;
        if ($this->getRequest()->has('parent_id'))
        {
            $vars['parent_id'] = $this->getRequest()->get('parent_id');
        }

        return $vars;
    }

    public function json()
    {
        $category = $this->$repository->getAllowed(['id', 'parent_id', 'name']);
        $category = $category->toArray();

        $tree = [];
        if (!empty($category)) {
            $tree = $this->$repository->getJsonTree($category);
        }

        return response()->json($tree);
    }

    public function updateTree()
    {
        $data = $this->getRequest()->all();

        if ($this->$repository->updateTree($data)) {
            return true;
        }
    }

    public function ajaxNestable()
    {
        $treeCategory['html'] = $this->repository->getViewNestableTree();

        return response()->json($treeCategory);
    }

    public function updateNestable()
    {
        $json = $this->getRequest()->all();

        if (empty($json['json'])) {
            return false;
        }

        $list = json_decode($json['json'], true);

        if ($this->$repository->updateNestableCategory($list)) {
            return true;
        }
    }

}
