<?php namespace App\Repositories\Eloquent\Common;
use App\Models\Common\Company;
use App\Repositories\Contracts\Common\CompanyRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class CompanyRepository extends Repository implements CompanyRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Company::class;
    }
}