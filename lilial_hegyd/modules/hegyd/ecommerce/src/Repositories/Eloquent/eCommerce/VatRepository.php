<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use Hegyd\eCommerce\Models\eCommerce\Vat;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\VatRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class VatRepository extends Repository implements VatRepositoryInterface
{

    public function model()
    {
        return Vat::class;
    }
}