<?php namespace Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog;

use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository extends Repository implements ProductRepositoryInterface
{

    public function model()
    {
        return Product::class;
    }

    public function active()
    {

        $product_class = config('hegyd-ecommerce.tables.product');
        $category_class = config('hegyd-ecommerce.tables.category');

        $products = Product::select("$product_class.*")
            ->join($category_class, "$category_class.id", '=', "$product_class.category_id")
            ->where("$product_class.active", true)
            ->where("$category_class.active", true)
            ->get();

        return $products;
    }

    /**
     * Return products by reference or name
     * @param $text
     * @param array $excludedIds
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function findByNameOrReference($text, $excludedIds = [], $limit = - 1, $columns = ['*'])
    {
        $products = Product::where(function ($q) use ($text) {
            return $q->where('name', 'like', "%$text%")
                ->orWhere('reference', 'like', "%$text%");
        });

        if (count($excludedIds))
        {
            if ($excludedIds instanceof Collection)
            {
                $excludedIds = $excludedIds->toArray();
            }

            $products = $products->whereRaw('id NOT IN (' . implode(',', $excludedIds) . ')');
        }

        if ($limit)
        {
            $products = $products->take($limit);
        }

        $products = $products->get($columns);

        return $products;
    }

    /**
     * Return products by reference, name or grip
     * @param $text
     * @param array $excludedIds
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function findByNameOrReferenceOrGrip($text, $excludedIds = [], $limit = - 1, $columns = ['*'])
    {
        $products = Product::where(function ($q) use ($text) {
            return $q->where('name', 'like', "%$text%")
                ->orWhere('reference', 'like', "%$text%")
                ->orWhere('grip', 'like', "%$text%");
        });

        if (count($excludedIds))
        {
            if ($excludedIds instanceof Collection)
            {
                $excludedIds = $excludedIds->toArray();
            }
            $products = $products->whereRaw('id NOT IN (' . implode(',', $excludedIds) . ')');
        }

        if ($limit)
        {
            $products = $products->take($limit);
        }

        $products = $products->get($columns);

        return $products;
    }

    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors)
    {
        if ($model->cartLines->count() || $model->orderLines->count())
        {
            return false;
        }

        return true;
    }

    /**
     * get list product by keyword
     * @param  integer $id      [description]
     * @param  string  $keyword [description]
     * @return [type]           [description]
     */
    public function listProductByKeyword($id = 0, $keyword = '')
    {

        $product_class = config('hegyd-ecommerce.tables.product');
        $category_class = config('hegyd-ecommerce.tables.category');

        $query = Product::select("$product_class.id", "$product_class.name as text")
            ->join($category_class, "$category_class.id", '=', "$product_class.category_id")
            ->where("$category_class.active", true)
            ->where("$product_class.active", true);

        if (!empty($id)) {
            $query->where("$product_class.id", '!=', $id);
        }

        if (!empty($keyword)) {
            $query->where("$product_class.name", 'LIKE', '%'.$keyword.'%');
        }

        $products = $query->limit(20)->get();

        var_dump($products);die();

        return $products;
    }

    /**
     * list product related for select2
     * @param  [type] $colection_related [description]
     * @return [type]                    [description]
     */
    public function getListProductRelated($colection_related)
    {
        if (empty($colection_related)) {
            return [];
        }

        return $this->getProductRelated($colection_related, ['id', 'name']);
    }

    /**
     * list product related full data
     * @param  [type] $colection_related [description]
     * @param  string $fields            [description]
     * @return [type]                    [description]
     */
    public function getProductRelated($colection_related, $fields = null)
    {
        if (empty($colection_related)) {
            return [];
        }
        // build list related id
        $related = $colection_related->map(function ($item) {
            return $item['related_id'];
        });

        $return = Product::where("active", true)
                            ->whereIn('id', $related->all())
                            ->get($fields);

        return $return;
    }

    /**
     * get list FAQ of 1 product
     * @param  [type] $colection_faqs [description]
     * @return [type]                 [description]
     */
    public function getProductFaq($colection_faqs)
    {
        if (empty($colection_faqs)) {
            return [];
        }

        // build list faq id
        $faqs = $colection_faqs->map(function ($item) {
            return $item['faq_id'];
        });

        $return = [];
        /*$return = FaqsRepository::whereIn('id', $faqs->all())
                                            ->get(['id', 'title']);*/

        return $return;
    }

    /**
     * get list feature of product
     * @param  [type] $colection [description]
     * @return [type]            [description]
     */
    public function getProductFeature($colection)
    {
        if (empty($colection)) {
            return [];
        }

        // build list feature id
        $return = $colection->map(function ($item) {
            return $item['option_id'];
        });

        return $return->all();
    }

    /**
     * get list product for page index
     * @param  array  $category [description]
     * @return [type]           [description]
     */
    public function getProductHome($category = [])
    {
        $limit = 3;

        foreach ($category as $cat) {
            $data[$cat['id']] = Product::where('active', true)
                                ->limit($limit)
                                ->orderBy('id', 'slug')
                                ->get();
            //->where('category_id', $cat['id'])
        }
        return $data;
    }

    /**
     * search product by category, keyword
     * @param  integer $cid     [description]
     * @param  string  $keyword [description]
     * @return [type]           [description]
     */
    public function getByCategory($cid = 0, $chidId = [])
    {
        $query = Product::where('active', true)->with(['category', 'brand']);

        if (!empty($cid)) {
            array_push($chidId, $cid);
            $query->whereIn('category_id', $chidId);
        }

        if (!empty($keyword)) {
            $query->search($keyword);
        }

        $data = $query->orderBy('id', 'slug')->paginate();

        return $data;
    }

    /**
     * get a product by slug
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function findBySlug($slug)
    {
        return Product::where('slug', $slug)->first();
    }

    /**
     * search product by param[], paging
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function getProductSearch($param)
    {
        $query = Product::where('active', true);

        if (!empty($param['keyword'])) {
            $query->filterReference($param['keyword']);
        }

        $data = $query->orderBy('id', 'slug')->paginate();

        return $data;
    }

    /**
     * get list REFERENCE by keyword
     * @param  [type] $keyword [description]
     * @return [type]          [description]
     */
    public function listReferenceByKeyword($keyword)
    {
        $query = Product::where('active', true);

        if (!empty($keyword)) {
            $query->filterReference($keyword);
        }

        $data = $query->pluck('reference');

        $return['suggestions'] = $data->map(function ($item, $key) {
            return ['value'=> $item, 'data'=> $item];
        });

        return $return;
    }

    /**
     * get list product lastest
     * @param  integer $limit [description]
     * @return [type]         [description]
     */
    public function getProductLastest($limit = 3)
    {
        $data = Product::with(['category','brand'])
                                ->where('active', true)
                                ->limit($limit)
                                ->orderBy('id', 'slug')
                                ->get();
        
        return $data;
    }

}