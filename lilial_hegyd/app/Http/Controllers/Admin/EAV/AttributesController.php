<?php namespace App\Http\Controllers\Admin\EAV;


use App\Http\Controllers\AbstractAppController;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\Apiable;
use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;
use App\Services\EAV\AttributeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributesController extends AbstractAppController
{

    use Apiable;

    public function __construct(Request $request, AttributeRepositoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;

    }

    public function index()
    {

        if ( ! \Entrust::can('admin.eav.index'))
        {
            abort(401);
        }

        // Retrieve attributes as associative array
        $attributes = app(AttributeService::class)->getAllGroupedByEntityKey();
        $entityKeys = array_unique(array_keys($attributes));
        //$attributeValues = $this->repository->all();

        $title = trans('eav.title.management');

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $breadcrumb = $this->breadcrumbs->addCrumb($title);

        return view(
            'app.contents.admin.eav.index',
            compact('attributes', 'entityKeys', 'breadcrumb', 'title')
        );
    }


}