<?php namespace Hegyd\eCommerce\Http\Controllers\Backend\ProductCatalog;


use Hegyd\eCommerce\Http\Controllers\Backend\AbstractBackendController;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\BrandRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\AttributeRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\FeatureRepositoryInterface;
use Hegyd\eCommerce\Models\ProductCatalog\ProductRelated;
use Hegyd\eCommerce\Models\ProductCatalog\ProductFaq;
use Hegyd\eCommerce\Models\ProductCatalog\ProductFeature;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Hegyd\Uploads\Repositories\Contracts\UploadRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Services\ImportService;

class ProductsController extends AbstractBackendController
{

    protected $uploadRepository;
    protected $bulkActions = [
        'excel',
        'import-zip',
        // 'active',
        // 'unactive'
    ];

    use Uploadable;


    public function __construct(Request $request, ProductRepositoryInterface $repository, UploadRepositoryInterface $uploadRepository)
    {
        parent::__construct($request, $repository);
        $this->uploadRepository = $uploadRepository;
    }

    public function configure()
    {
        $table = config('hegyd-ecommerce.tables.product');
        $categories_table = config('hegyd-ecommerce.tables.category');
        $brand_table = config('hegyd-ecommerce.tables.product_brand');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-ecommerce.routes.backend.prefix.product'),
                'lang'  => 'hegyd-ecommerce::products.',
                'view'  => 'hegyd-ecommerce::backend.contents.products.',
                'acl'   => config('hegyd-ecommerce.permissions.prefix.backend.product'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'name',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.name',
                $table . '.reference',
                $table . '.brand_id',
                $table . '.description',
                $table . '.category_id',
                $brand_table . '.name as brand_name',
            ],
            'left_join'        => [
                [$brand_table, $table . '.brand_id', '=', $brand_table . '.id']
            ],
            // the columns configuration
            'columns'          => [
                'id'          => [
                    'title'     => 'ID',
                    'type'      => 'text',
                    'filterKey' => $table . '.id',
                    'class_row' => 'text-left',
                ],
                'visual'        => [
                    'title'     => 'hegyd-ecommerce::products.fields.visual',
                    'type'      => 'image',
                    'relation'  => 'visual',
                    'callBack'  => 'printImage',
                    'class_row' => 'text-center',
                ],
                'name'          => [
                    'title'     => 'hegyd-ecommerce::products.fields.name',
                    'type'      => 'text',
                    'filterKey' => $table . '.name',
                    'route'     => config('hegyd-ecommerce.routes.backend.product.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                    'class_row' => 'text-left',
                ],
                'reference'          => [
                    'title'     => 'hegyd-ecommerce::products.fields.reference',
                    'type'      => 'text',
                    'filterKey' => $table . '.reference',
                    'class_row' => 'text-left',
                ],
                'brand_name' => [
                    'title'         => 'hegyd-ecommerce::products.fields.brand',
                    'type'          => 'select',
                    'listPopulator' => 'populateBrands',
                    'filterKey'     => $table . '.brand_id',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                'active'        => [
                    'title'     => 'hegyd-ecommerce::products.fields.active',
                    'type'      => 'bool',
                    'filterKey' => $table . '.active',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }

    public function configureUploads()
    {
        return [
            'visual'  => [
                'type'        => 'image',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ],
            'visuals' => [
                'type'        => 'image',
                'relation'    => Upload::RELATION_MULTIPLE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_SECOND_VISUAL,
            ],
        ];
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

    public function storeUpload($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $this->model = $this->getRepository()->findOrFail($id);

        $this->validation($this->getRequest()->all());

        $this->saveFiles($this->getRequest()->all(), $this->model);

        return response()->json();
    }

    public function updateUploads($productId)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $uploadRepository = app(UploadRepositoryInterface::class);
        $datas = $this->getRequest()->get('uploads', []);

        foreach ($datas as $data)
        {

            if ( ! isset($data['id']) || ! isset($data['position']))
                continue;

            $uploadRepository->reset();
            $upload = $uploadRepository->find($data['id']);

            if ($upload)
            {
                $upload->position = $data['position'];
                $uploadRepository->updateRich($upload->getAttributes(), $upload->id);
            }
        }

        return $this->successJsonResponse();
    }

    public function deleteUpload($productId, $uploadId)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $upload = $this->uploadRepository->findOrFail($uploadId);
        $this->addFileToDelete($upload);
        $deleted = $this->uploadRepository->delete($upload->id);

        if ($deleted)
        {
            $this->runDeleteFiles();

            return response()->json();
        }

        return response(500)->json();
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas, $model);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }

        // parse file excel to json
        if ($this->getRequest()->hasFile('file_table_declension')) {
            $file = $this->getRequest()->file_table_declension;
            if (!empty($file)) {
                $json = \Excel::load($file->getRealPath())->get()->toJson();
                $datas['table_declension'] = $json;
            }
        }

        return $datas;
    }

    protected function afterSave(Model $model, $data = [])
    {
        // save related
        $data_related = !empty($data['related']) ? $data['related'] : [];
        ProductRelated::updateRelated($model->id, $data_related);

        // save faqs
        $data_faq = !empty($data['faqs']) ? $data['faqs'] : [];
        ProductFaq::updateFaq($model->id, $data_faq);

        // save feature
        //ProductFeature::updateFeature($model->id, $data['feature']);

        return parent::afterSave($model, $data);
    }

    public function create()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }
        $title = $this->getTitle();

        if ( ! $this->getRequest()->ajax())
        {
            $this->createFormBreadCrumb($title);
        }

        $model = $this->getRepository()->getModel();
        $route = $this->routeAlias('store');
        $view = $this->getConfig('views.create');

        $viewVars['categories']    = app(CategoryRepositoryInterface::class)->getCategoryTree();
        $viewVars['brands']        = app(BrandRepositoryInterface::class)->pluck('name', 'id');
        $viewVars['tree_category'] = app(CategoryRepositoryInterface::class)->getParentTree();
        $viewVars['list_feature']  = app(FeatureRepositoryInterface::class)->getAllowed();
        
        return $this->displayFormView($view, $title, $model, $route, 'post', $viewVars);
    }

    public function edit($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $this->model = $this->getRepository()->find($id);
        if ($this->model == null)
        {
            $this->notifyError($this->trans('labels.not_found'));

            return redirect()->route($this->routeAlias('index'));
        }
        $this->model = $this->beforeDisplay($this->model);

        $title = $this->getTitle($this->model);

        if ( ! $this->getRequest()->ajax())
        {
            $this->createFormBreadCrumb($title, $this->model);
        }

        $route = $this->routeAlias('update', ['id' => $this->model->id]);
        $route = [$route, $this->model->id];
        $view = $this->getConfig('views.update');

        $viewVars['categories']    = app(CategoryRepositoryInterface::class)->getCategoryTree();
        $viewVars['brands']        = app(BrandRepositoryInterface::class)->pluck('name', 'id');
        $viewVars['tree_category'] = app(CategoryRepositoryInterface::class)->getParentTree();
        $viewVars['related']       = $this->getRepository()->getListProductRelated($this->model->productRelated);
        $viewVars['list_feature']  = app(FeatureRepositoryInterface::class)->getAllowed();
        $viewVars['feature']       = $this->getRepository()->getProductFeature($this->model->productFeature);

        return $this->displayFormView($view, $title, $this->model, $route, 'put', $viewVars);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        return $vars;
    }

    public function populateCategories()
    {
        return app(CategoryRepositoryInterface::class)->order('name')->pluck('name', 'id');
    }

    public function populateBrands()
    {
        return app(BrandRepositoryInterface::class)->order('name')->pluck('name', 'id');
    }

    public function ajaxProductRelated()
    {
        $id = $this->getRequest()->get('id');
        $keyword = $this->getRequest()->get('q');

        return $this->getRepository()->listProductByKeyword($id, $keyword);
    }

    public function ajaxBrandLogo()
    {
        $id = $this->getRequest()->get('id');
        
        $model = app(BrandRepositoryInterface::class)->find($id);

        if (!empty($model->logo)) {
            $logo = url('app/img/logo/' . $model->logo);
            return ['logo' => $logo];
        }

        return [];

    }

    public function importZip(Request $request, ImportService $import)
    {
        if($request->hasFile('zip_file'))
        {
            set_time_limit(0);
            ini_set('max_execution_time', 0);

            $filename = $request->file('zip_file')->getRealPath();

            $result = $import->import($filename, false);

            return $result;
        }
        else {
            return [
                'message' => __('file_not_exist'),
                'alert-type' => 'error',
            ];
        }

    }

}
