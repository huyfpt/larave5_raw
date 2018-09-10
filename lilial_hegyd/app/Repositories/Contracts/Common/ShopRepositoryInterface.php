<?php namespace App\Repositories\Contracts\Common;

interface ShopRepositoryInterface
{

    public function searchByTerm($term, $limit = 20);

    public function searchByTermAndPaginate($term, $paginate = 10);

    public function getDisplayDirectoryShops();

    public function getActiveShops();
}