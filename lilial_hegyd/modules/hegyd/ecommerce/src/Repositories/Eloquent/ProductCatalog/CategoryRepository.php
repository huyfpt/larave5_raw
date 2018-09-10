<?php namespace Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog;

use Hegyd\eCommerce\Models\ProductCatalog\Category;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    public static $_categories = [];
    public static $_category_ids = [];

    public function model()
    {
        return Category::class;
    }

    public function getAllowed($columns = ['*'])
    {
        return Category::where('active', true)->orderBy('ranking')->get($columns);
    }

    public function getAll($columns = ['*'])
    {
        return Category::orderBy('ranking')->get($columns);
    }

    public function search($text, $returnBuilder = false, $limit = - 1)
    {
        $allowed_ids = $this->getAllowed(['id'])->lists('id')->toArray();

        $categories = Category::query();

        if (count($allowed_ids))
        {
            $categories = $categories->where('name', 'like', "%$text%")
                ->whereRaw('id IN (' . implode(',', $allowed_ids) . ')')
                ->limit(- 1);
        } else
        {
            $categories = $categories->whereRaw('0 = 1');
        }

        if ($returnBuilder)
        {
            return $categories;
        }

        return $categories->get();
    }

    public function _buildTree($elements, &$return, $parentId = 0, $slug = '|--', $current_id = 0) 
    {
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {

                if ($current_id == $element['id']) {
                    continue;
                }
                
                $return[] = [   'id' => $element['id'], 
                                'name' => $slug .' '. $element['name'],
                            ];


                $new_current_id = $current_id;
                if ($element['parent_id'] == $current_id) {
                    $new_current_id = $element['id'];
                }

                $this->_buildTree($elements, $return, $element['id'], $slug . '|--', $new_current_id);
            }
        }
    }

    public function getParentTree($current_id = 0)
    {
        $category = $this->getAllowed(['id', 'parent_id', 'name']);

        $return = [];
        $this->_buildTree($category, $return, 0, '|--', $current_id);
        $collection = collect($return);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });

        return [0 => __('hegyd-ecommerce::categories.labels.root')] + $keyed->all();
    }

    public function getCategoryTree()
    {
        $category = $this->getAllowed(['id', 'parent_id', 'name']);

        $return = [];
        $this->_buildTree($category, $return, 0, '');
        $collection = collect($return);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });
        
        return $keyed->all();
    }

    /**
     * build html view nestable tree
     * @param  [type]  &$elements [description]
     * @param  integer $parentId  [description]
     * @param  [type]  $return    [description]
     * @return [type]             [description]
     */
    public function buildViewNestableTree(&$elements, $parentId = 0, $return) {

        $branch = array();    
        $return .= '<ol class="dd-list">';
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildViewNestableTree($elements, $element['id'], '');

                $edition_url = url('/admin/referentiel/categories/'. $element['id'] .'/edition');
                $delete_url = url('/admin/referentiel/categories/'. $element['id']);

                $return .= '<li class="dd-item dd3-item" data-id="'. $element['id'] .'">';
                $return .= '    <div class="dd-handle dd3-handle">Drag</div>
                                <div class="dd3-content">
                                    <a href="'. $edition_url .'">'. $element['name'] .'</a>
                                </div>
                                ';

                $return .= '<div class="dd-delete">';
                $return .= '<a data-toggle="tooltip" 
                            data-placement="top"          
                            title="Remove" alt="Remove" 
                            data-original-title="Supprimer" 
                            data-delete-url="'. $delete_url .'" 
                            data-text="">
                            <i class="fa fa-trash"></i>
                            </a>';
                $return .=  '</div>';

                if ($children != '' && $children != '<ol class="dd-list"></ol>') {
                    $return .=      $children;
                }

                $return .= '</li>';
            }
        }
        $return .= '</ol>';

        return $return;
    }

    public function getViewNestableTree($parentId = 0)
    {
        $category = $this->getAll(['id', 'parent_id', 'name']);
        $category = $category->toArray();

        if (empty($category)) {
            return false;
        }

        return $this->buildViewNestableTree($category, $parentId = 0, '');
    }

    /**
     * update ordering category
     * @param  [type]  $list      [description]
     * @param  integer $parentId  [description]
     * @param  integer &$position [description]
     * @return [type]             [description]
     */
    public function updateNestableCategory($list, $parentId = 0, &$position = 0)
    {
        foreach ($list as $item) {

            $model = Category::find($item['id']);
            $model->parent_id = $parentId;
            $model->ranking = $position;
            $model->save();

            $position++;
            if (!empty($item['children'])) {
                $this->updateNestableCategory($item['children'], $item['id'], $position);
            }
        }
    }

    /**
     * get category by slug
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getBySlug($slug)
    {
        return Category::where('active', true)->where('slug', $slug)->first();
    }
    
    /**
     * get list category child 1 level
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    public function getChildCategory($parent_id)
    {
        return Category::where('active', true)->where('parent_id', $parent_id)->get(['id', 'name', 'slug'])->toArray();
    }

    /**
     * get list parent
     * @param  [type] $category_id [description]
     * @return [type]              [description]
     */
    public function getListParent($parent_id, &$return)
    {
        $model = Category::where('active', true)->where('id', $parent_id)->first();

        $return[] = $model;

        if (!empty($model->parent_id)) {
            $this->getListParent($model->parent_id, $return);
        }
    }

    public function getAllChildId($category_id)
    {
        $data = Category::where('active', true)->get(['id', 'parent_id'])->toArray();

        return $this->_getAllChildId($data, $category_id);
    }

    protected function _getAllChildId($data, $cid)
    {
        if (empty($data)) {
            return null;
        }

        $return = [];
        foreach ($data as $key=>$item) {

            unset($data[$key]);

            if ($item['parent_id'] == $cid) {
                $return[] = $item['id'];

                $child = $this->_getAllChildId($data, $item['id']);

                if (!empty($child)) { 
                    $return = array_merge($return, $child);
                }

            }


        }

        return $return;
    }

}