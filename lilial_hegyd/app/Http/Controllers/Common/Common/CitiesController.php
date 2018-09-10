<?php namespace App\Http\Controllers\Common\Common;

use App\Repositories\Contracts\Common\CityRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{

    protected $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            return $this->_indexAjax($request);
        }
    }

    private function _indexAjax(Request $request)
    {
        $query = $request->get('query');

        $countries = $this->repository->findByName($query, 0, 30);

        return $countries;
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax())
        {
            return $this->_showAjax($request, $id);
        }
    }

    private function _showAjax(Request $request, $id)
    {
        return $this->repository->find($id);
    }

}
