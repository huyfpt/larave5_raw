<?php namespace App\Services\Common;

use App\Models\Common\Country;
use App\Repositories\Contracts\Common\CountryRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class CountryService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelectList()
    {
        return $this->repository->pluck('title_fr', 'id');
    }

}