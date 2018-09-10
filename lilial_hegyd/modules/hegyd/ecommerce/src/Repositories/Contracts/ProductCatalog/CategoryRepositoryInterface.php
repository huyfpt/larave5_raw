<?php namespace Hegyd\eCommerce\Repositories\Contracts\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Category;

interface CategoryRepositoryInterface
{
    public function getAllowed($columns = ['*']);

    public function search($text, $returnBuilder = false, $limit = -1);

    public function getParentTree($current_id = 0);
    
    public function getCategoryTree();

    public function getViewNestableTree($parentId = 0);

    public function updateNestableCategory($list, $parentId = 0, &$position = 0);
    
}