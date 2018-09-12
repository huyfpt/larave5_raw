<?php
namespace Hegyd\Faqs\Controllers\Frontend;

use Hegyd\Faqs\Models\FaqsLike;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class FaqsController
 * @package Hegyd\Faqs\Controllers\Frontend
 */
class FaqsController extends AbstractFrontendController
{
    protected $category_repository;

    public function __construct(Request $request, FaqsRepositoryInterface $repository,
                                FaqsCategoryRepositoryInterface $category_repository)
    {
        parent::__construct($request, $repository);
        $this->category_repository = $category_repository;
    }

    protected function configure()
    {
        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-faqs.routes.frontend.prefix.faqs'),
                'lang'  => 'hegyd-faqs::faqs.',
                'view'  => 'hegyd-faqs::frontend.faqs.',
                'acl'   => config('hegyd-faqs.permissions.prefix.frontend.faqs'),
            ],
        ];

    }

    public function index(Request $request)
    {
        $categories = $this->category_repository->active();

        $user = auth()->user();

        $title = $this->trans('title.index');
        $heading = $this->trans('title.heading');
        // dd($title);
        // $breadcrumb = $this->breadcrumbs->addCrumb(trans('app.index'), '/');
        // $breadcrumb->addCrumb($title);
        $faqs = $this->repository->active($request);
        if($request->ajax()){
            // check if request is filter by category
            if ($request->has('category') && !$request->has('page')) {

                $faqs = $this->repository->getByCategory($request->category);

                return view('hegyd-faqs::frontend.faqs.includes.list_faqs', compact('title', 'heading', 'faqs', 'categories'))->render();
            }
            return view('hegyd-faqs::frontend.faqs.includes.list_faqs', compact('title', 'heading', 'faqs', 'categories'))->render();
        }

        $category_id = 0;
        if ($request->has('category_id')) {
            $category_id = $request->category_id;
        }
        
        return view(
            'hegyd-faqs::frontend.faqs.index',
            compact('title', 'faqs', 'heading', 'categories', 'category_id')
        );
    }

    public function show(Request $request)
    {
        $user = auth()->user();

        $faq = $this->repository->getFaqBySlug($request);

        $category = $faq->category;

        $title = trans('hegyd-faqs::faqs.title.show', ['title' => $faq->title]);

        $category_title = $category ? $category->label : '';
        $category_url = $category ? $category->url() : '';

        $breadcrumb = $this->breadcrumbs->addCrumb(trans('app.index'), '/');
        $this->breadcrumbs->addCrumb(
            trans('hegyd-faqs::faqs.title.index'),
            route(config('hegyd-faqs.routes.frontend.faqs.index'))
        );
        $breadcrumb->addCrumb(
            trans('hegyd-faqs::faqs.title.show', ['title' => $category_title]),
            $category_url
        );
        $breadcrumb->addCrumb($faqs->label);

        return view('hegyd-faqs::frontend.faqs.show', compact('title', 'faq', 'breadcrumb'));
    }

    public function like($id) {
        $user = auth()->user();

        $like_status = $this->getRequest()->get('like_status');

        $faqs = $this->repository->findOrFail($id);

        $extranet_service = app(config('hegyd-faqs.services.extranet'));
        $role = $extranet_service->getRole();

        if(! in_array($role->name, config('hegyd-faqs.administrators')))
        {
            $role_id = $role->id;

            $canShow = app(config('hegyd-faqs.filters.faqs'))->canShow($faqs);

            $roles = $faqs->roles()->pluck('role_id')->toArray();

            if(!in_array($role_id, $roles) || !$canShow)
                abort(403, trans('hegyd-faqs::faqs.message.access_denied'));
        }

        $faqs_like = $this->like_repository->updateStatus($faqs->id, $user->id, $like_status);

        return $this->_returnLikeView($faqs);
    }

    private function _returnLikeView(Model $model, $additional_datas = [])
    {
        $additional_datas['view'] = $this->_getLikeView($model);

        return $this->successJsonResponse(Response::HTTP_OK, $additional_datas);
    }

    private function _getLikeView(Model $model)
    {
        $can_edit = auth()->user()->can(config('hegyd-faqs.permissions.backend.faqs.edit'));
        return $this->view('faqs_like', ['model' => $model, 'can_edit' => $can_edit])->render();
    }
}