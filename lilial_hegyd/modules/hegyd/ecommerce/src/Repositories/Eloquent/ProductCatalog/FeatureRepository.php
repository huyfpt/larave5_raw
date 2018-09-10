<?php namespace Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog;

use Hegyd\eCommerce\Models\ProductCatalog\Feature;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\FeatureRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class FeatureRepository extends Repository implements FeatureRepositoryInterface
{

    public function model()
    {
        return Feature::class;
    }

    public function getAllowed($columns = ['*'])
    {
        return Feature::where('active', true)->get($columns);
    }


}