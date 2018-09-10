<?php namespace App\Http\Controllers\Extranet\Common;


use App\Http\Controllers\Extranet\AbstractExtranetController;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use Illuminate\Http\Request;

class ShopsController extends AbstractExtranetController
{

    public function __construct(Request $request, ShopRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    public function search()
    {
        if ( ! $this->getRequest()->ajax())
            abort(401);

        $term = $this->getRequest()->get('query');

        $shops = $this->repository->searchByTerm($term);

        return $shops->pluck('name', 'id');
    }
}