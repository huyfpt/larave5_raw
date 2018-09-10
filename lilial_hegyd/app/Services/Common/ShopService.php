<?php namespace App\Services\Common;

use App\Models\Common\Shop;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class ShopService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(ShopRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelectList()
    {
        return $this->repository->pluck('name', 'id');
    }

}