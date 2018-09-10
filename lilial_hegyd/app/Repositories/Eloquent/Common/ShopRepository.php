<?php namespace App\Repositories\Eloquent\Common;

use App\Models\Common\Shop;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class ShopRepository extends Repository implements ShopRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Shop::class;
    }

    public function searchByTerm($term, $limit = 20)
    {
        return $this->_searchByTerm($term)->limit($limit)->get();
    }

    public function searchByTermAndPaginate($term, $paginate = 10)
    {
        return $this->_searchByTerm($term)->paginate($paginate);
    }

    private function _searchByTerm($term)
    {
        $query = Shop::select('shops.*')
            ->leftJoin('addresses', function ($join)
            {
                $join->on('addresses.addressable_id', '=', 'shops.id')
                    ->where('addresses.addressable_type', '=', Shop::class);
            })
            ->where(function ($q) use ($term)
            {
                return $q->where('shops.name', 'like', '%' . $term . '%')
                    ->orWhere('addresses.zip', 'like', $term . '%')
                    ->orWhere('addresses.city', 'like', '%' . $term . '%');
            })
            ->where('shops.active', true)
            ->orderBy('shops.name');


        return $query;
    }

    public function getDisplayDirectoryShops($paginate = 9)
    {
        return Shop::where('active', true)->orderBy('name')->paginate($paginate);
    }

    public function getActiveShops()
    {
        return Shop::where('active', true)->orderBy('name')->get();
    }
}