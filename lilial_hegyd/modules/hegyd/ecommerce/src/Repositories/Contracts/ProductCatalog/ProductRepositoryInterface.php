<?php namespace Hegyd\eCommerce\Repositories\Contracts\ProductCatalog;


interface ProductRepositoryInterface
{

    /**
     * Return products by reference or name
     * @param $text
     * @param array $excludedIds
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function findByNameOrReference($text, $excludedIds = [], $limit = - 1, $columns = ['*']);

    /**
     * Return products by reference, name or grip
     * @param $text
     * @param array $excludedIds
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function findByNameOrReferenceOrGrip($text, $excludedIds = [], $limit = - 1, $columns = ['*']);

}