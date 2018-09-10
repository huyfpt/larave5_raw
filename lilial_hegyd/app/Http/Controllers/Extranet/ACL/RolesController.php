<?php namespace App\Http\Controllers\Extranet\ACL;


use App\Http\Controllers\Extranet\AbstractExtranetController;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RolesController extends AbstractExtranetController
{

    public function __construct(Request $request, RoleRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    public function search()
    {
        if ( ! $this->getRequest()->ajax())
            abort(401);

        $term = $this->getRequest()->get('query');

        $roles = $this->repository->searchByTerm($term);

        return $roles->pluck('display_name', 'id');
    }
}