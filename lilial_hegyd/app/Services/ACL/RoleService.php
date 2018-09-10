<?php namespace App\Services\ACL;

use App\Models\ACL\Role;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class RoleService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSelectList()
    {
        return $this->repository->getAll()->pluck('display_name', 'id');
    }

    public function getOtherSelectList()
    {
        return $this->repository->getOthers()->pluck('display_name', 'id');
    }
}