<?php namespace Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog;

use Hegyd\eCommerce\Models\ProductCatalog\Brand;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\BrandRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class BrandRepository extends Repository implements BrandRepositoryInterface
{

    public function model()
    {
        return Brand::class;
    }

    public function getAll()
    {
        return Brand::where('active', true)->get();
    }

}