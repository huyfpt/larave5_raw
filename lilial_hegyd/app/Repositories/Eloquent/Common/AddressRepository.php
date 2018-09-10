<?php namespace App\Repositories\Eloquent\Common;


use App\Models\Common\Address;
use App\Repositories\Contracts\Common\AddressRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class AddressRepository extends Repository implements AddressRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Address::class;
    }
}