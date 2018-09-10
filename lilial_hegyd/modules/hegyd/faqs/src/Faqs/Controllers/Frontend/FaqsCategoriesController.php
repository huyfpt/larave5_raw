<?php
namespace Hegyd\Faqs\Controllers\Frontend;

use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class FaqsCategoriesController
 * @package Hegyd\Faqs\Controllers\Frontend
 */
class FaqsCategoriesController extends AbstractFrontendController
{

    protected $faqs_repository;

    public function __construct(
                                Request $request,
                                FaqsCategoryRepositoryInterface $repository,
                                FaqsRepositoryInterface $faqs_repository
    )
    {
        parent::__construct($request, $repository);
        $this->faqs_repository = $faqs_repository;
    }

    protected function configure()
    {
        return [
            // the prefix for the view routing, lang and view
            'prefixes' => [
                'route' => config('hegyd-faqs.routes.frontend.prefix.faqs_category'),
                'lang'  => 'hegyd-faqs::faqs_categories.',
                'view'  => 'hegyd-faqs::frontend.categories.',
                'acl'   => config('hegyd-faqs.permissions.prefix.frontend.faqs_category'),
            ],
        ];
    }

    public function index()
    {
        $user = auth()->user();

        // if ( ! $user != null || ! $this->acl('index')) {
        //     abort(403, $this->trans('message.access_denied'));
        // }

        $title = $this->trans('title.index');

        $this->breadcrumbs->addCrumb(trans('app.index'), '/');
        $this->breadcrumbs->addCrumb($title);

        $can_add = $user->can(config('hegyd-faqs.permissions.backend.faqs_category.create'));
        $can_edit = $user->can(config('hegyd-faqs.permissions.backend.faqs_category.edit'));

        /**
         * Admin show all faqs active or inactive
         */
        if ($can_edit) {
            $categories = $this->repository->order('label')->all();
        } else {
            $categories = $this->repository->active();
        }

        return view(
            'hegyd-faqs::frontend.categories.index',
            compact('categories', 'title', 'can_add', 'can_edit')
        );
    }

    public function show($slug, $id)
    {
        $user = auth()->user();

        if ( ! $user != null || ! $this->acl('index'))
        {
            abort(403, $this->trans('message.access_denied'));
        }

        $category = $this->repository->findOrFail($id);

        $can_edit_category = $user->can(config('hegyd-faqs.permissions.backend.faqs_category.edit'));

        if ( ! $category->active && ! $can_edit_category)
            abort(404);

        // If URL is not correct, then redirect to the good category URL
        if ($redirectTo = $this->unvalidateUrlThenRedirect($category))
            return $redirectTo;

        $title = trans('hegyd-faqs::faqs_categories.title.show', ['label' => $category->label]);

        $this->breadcrumbs->addCrumb(trans('app.index'), '/');
        $this->breadcrumbs->addCrumb(
            trans('hegyd-faqs::faqs.title.index'),
            route(config('hegyd-faqs.routes.frontend.faqs_category.index'))
        );
        $this->breadcrumbs->addCrumb($title);

        /**
         * Admin show all faqs active or inactive
         */
        if ($can_edit_category)
        {
            $categories = $this->repository->order('label')->all();
            $all_faqs = $this->faqs_repository->getByCategory($category->id);
        } else
        {
            $categories = $this->repository->active();
            $all_faqs = $this->faqs_repository->getActiveByCategory($category->id);
        }

        $can_add = $user->can(config('hegyd-faqs.permissions.backend.faqs.create'));
        $can_edit = $user->can(config('hegyd-faqs.permissions.backend.faqs.edit'));

        return view(
            'hegyd-faqs::frontend.categories.show',
            compact(
                'title',
                'categories',
                'category',
                'all_faqs',
                'can_add',
                'can_edit',
                'can_edit_category'
            )
        );
    }

    public function showList($slug, $id)
    {
        // get all faqs by an specific category slug
        $faqs = $this->faqs_repository->getByCategory($id);
        $categories = $this->repository->active();
        $category_id = $id;
        $title = trans('hegyd-faqs::faqs_categories.title.show', ['label' => $category->label]);

        // $this->breadcrumbs->addCrumb(trans('app.index'), '/');
        // $this->breadcrumbs->addCrumb(
        //     trans('hegyd-faqs::faqs.title.index'),
        //     route(config('hegyd-faqs.routes.frontend.faqs_category.index'))
        // );
        $this->breadcrumbs->addCrumb($title);
        return view(
            'hegyd-faqs::frontend.faqs.index',
            compact('title', 'faqs', 'categories', 'category_id')
        );
    }
}