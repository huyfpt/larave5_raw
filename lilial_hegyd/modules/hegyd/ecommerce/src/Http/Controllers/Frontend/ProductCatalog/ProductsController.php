<?php namespace Hegyd\eCommerce\Http\Controllers\Frontend\ProductCatalog;


use Hegyd\eCommerce\Http\Controllers\Frontend\AbstractFrontendController;
use Hegyd\eCommerce\Http\Controllers\Traits\Apiable;
use Hegyd\eCommerce\Http\Controllers\Traits\Configurable;
use Hegyd\eCommerce\Http\Controllers\Traits\Datatable;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Services\ProductCatalog\ProductService;
use Illuminate\Http\Request;

class ProductsController extends AbstractFrontendController
{

    use Apiable, Datatable;

    protected $category_repository;
    protected $product_service;

    public function __construct(Request $request, ProductRepositoryInterface $repository, CategoryRepositoryInterface $category_repository)
    {
        parent::__construct($request, $repository);
        $this->category_repository = $category_repository;
        $this->product_service = app(ProductService::class);

        $this->readConfiguration();
        $this->prepareColumns();
    }

    protected function configure()
    {
        $table = config('hegyd-ecommerce.tables.product');
        $categories_table = config('hegyd-ecommerce.tables.category');

        return [
            'rows_actions_template' => 'includes.datatable.actions',
            // the prefix for the view routing, lang and view
            'prefixes'              => [
                'route' => config('hegyd-ecommerce.routes.frontend.prefix.product'),
                'lang'  => 'hegyd-ecommerce::products.',
                'view'  => 'hegyd-ecommerce::frontend.contents.products.',
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
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name'      => 'name',
            // the select fields used when retrieving rows
            'select'                => [
                $table . '.id',
                $table . '.active',
                $table . '.name',
                $table . '.reference',
                $table . '.stock',
                $table . '.price',
                $table . '.price as price_ttc',
                $table . '.category_id',
                $categories_table . '.name as category_name',
            ],
            'left_join'             => [
                [$categories_table, $table . '.category_id', '=', $categories_table . '.id'],
            ],
            'where'                 => [
                "$table.active"            => true,
                "$categories_table.active" => true,
            ],
            // the columns configuration
            'columns'               => [
                'id'            => [
                    'title'     => 'hegyd-ecommerce::products.fields.visual',
                    'type'      => 'image',
                    'relation'  => 'visual',
                    'route'     => config('hegyd-ecommerce.routes.frontend.product.show'),
                    'route_id'  => 'id',
                    'target'    => '_self',
                    'callBack'  => 'printImage',
                    'orderable' => false,
                    'class'     => 'col-md-1',
                ],
                'reference'     => [
                    'title'     => 'hegyd-ecommerce::products.fields.reference',
                    'type'      => 'text',
                    'filterKey' => $table . '.reference',
                    'route'     => config('hegyd-ecommerce.routes.frontend.product.show'),
                    'route_id'  => 'id',
                    'target'    => '_self',
                    'callBack'  => 'printLink',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'name'          => [
                    'title'     => 'hegyd-ecommerce::products.fields.name',
                    'type'      => 'text',
                    'filterKey' => $table . '.name',
                    'route'     => config('hegyd-ecommerce.routes.frontend.product.show'),
                    'route_id'  => 'id',
                    'target'    => '_self',
                    'callBack'  => 'printLink',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'category_name' => [
                    'title'         => 'hegyd-ecommerce::products.fields.category',
                    'type'          => 'select',
                    'listPopulator' => 'populateCategories',
                    'filterKey'     => $table . '.category_id',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                'price'         => [
                    'title'          => 'hegyd-ecommerce::products.fields.price',
                    'type'           => 'text',
                    'filterKey'      => $table . '.price',
                    'class_row'      => 'text-center',
                    'class'          => 'col-md-1',
                    'callBack'       => 'printPrice',
                    'disable_filter' => true,
                ],
                'price_ttc'     => [
                    'title'          => 'hegyd-ecommerce::products.fields.price_ttc',
                    'type'           => 'text',
                    'filterKey'      => $table . '.price_ttc',
                    'class_row'      => 'text-center',
                    'class'          => 'col-md-1',
                    'callBack'       => 'printPriceTtc',
                    'disable_filter' => true,
                ],
                'stock'         => [
                    'title'          => 'hegyd-ecommerce::products.fields.stock',
                    'type'           => 'text',
                    'filterKey'      => $table . '.stock',
                    'class_row'      => 'text-center',
                    'callBack'       => 'printStock',
                    'class'          => 'col-md-1',
                    'disable_filter' => true,
                ],
            ],
        ];
    }

    public function index()
    {
        $childCategory = $this->category_repository->getChildCategory(0);
        $data = $this->repository->getProductHome($childCategory);

        $this->breadcrumbs->addCrumb(trans('app.index'), route('index'));
        $this->breadcrumbs->addCrumb(trans('products.title.index'));
        $breadcrumb = $this->breadcrumbs;

        $h1 = trans('products.title.index_h1');
        $keyword = '';

        return view('front.product.index', compact('data', 'breadcrumb', 'childCategory', 'h1', 'keyword'));
    }

    public function search()
    {
        $keyword = $this->_request['keyword'];
        $param['keyword'] = $keyword;

        $childCategory = $this->category_repository->getChildCategory(0);
        $data = $this->repository->getProductSearch($param);

        $h1 = trans('products.title.search_result');

        $this->breadcrumbs->addCrumb(trans('app.index'), route('index'));
        $this->breadcrumbs->addCrumb(trans('products.title.index'), $this->route('index'));
        $this->breadcrumbs->addCrumb($h1);
        $breadcrumb = $this->breadcrumbs;

        return view('front.product.category', compact('data', 'breadcrumb', 'childCategory', 'h1', 'keyword'));
    }

    public function category($slug)
    {
        $slug = $this->_request['slug'];

        $childCategory = $this->category_repository->getChildCategory(0);
        $category = $this->category_repository->getBySlug($slug);
        $childId = $this->category_repository->getAllChildId($category->id);

        $data = [];
        if (!empty($category)) {
            $data = $this->repository->getByCategory($category->id, $childId);
        }

        $this->breadcrumbs->addCrumb(trans('app.index'), route('index'));
        $this->breadcrumbs->addCrumb($this->trans('title.management'), $this->route('index'));
        if (!empty($category->name)) {
            $this->breadcrumbs->addCrumb($category->name);
        }

        $breadcrumb = $this->breadcrumbs;
        $h1 = $category->name;
        $keyword = '';

        return view('front.product.category', compact('data', 'category', 'breadcrumb', 'childCategory', 'keyword', 'h1'));
    }

    public function show($slug)
    {
        $product = $this->repository->findBySlug($slug);

        if (empty($product)) {
            abort(404);
        }

        $category = $product->category;
        $cateParent[] = $category;
        $this->category_repository->getListParent($category->parent_id, $cateParent);
        $cateParent = array_reverse($cateParent);

        $breadcrumb = $this->breadcrumbs->addCrumb(trans('app.index'), route('index'));
        $breadcrumb->addCrumb($this->trans('title.management'), $this->route('index'));

        $i = 0;
        foreach ($cateParent as $cate) {
            if ($i++ > 1) break;
            $breadcrumb->addCrumb($cate->name, url('/produits/category/'. $cate->slug));
        }
        $breadcrumb->addCrumb($product->name);

        $related = $this->repository->getProductRelated($product->productRelated);


        return view('front.product.show', compact('product', 'breadcrumb', 'related'));
    }

    public function populateCategories()
    {
        return app(CategoryRepositoryInterface::class)->getAllowed()->pluck('name', 'id');
    }

    public function printStock($field, $value, $id)
    {
        $product = $this->repository->find($id);

        return $this->product_service->currentStock($product);
    }

    public function printPriceTtc($field, $value, $id)
    {
        $product = $this->repository->findOrFail($id);
        $price = $this->product_service->priceTtc($product);

        return self::printPrice($field, $price, $id);
    }

    public function suggest()
    {
        $keyword = $this->getRequest()->get('q');

        return $this->getRepository()->listReferenceByKeyword($keyword);
    }
}