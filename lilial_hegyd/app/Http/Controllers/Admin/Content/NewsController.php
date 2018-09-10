<?php

namespace App\Http\Controllers\Admin\Content;

use App\Events\Notifications\Content\NewsAvailableEvent;
use App\Jobs\NotifyUsers;
use \Hegyd\News\Controllers\Backend\NewsController as Controller;
use Illuminate\Database\Eloquent\Model;
use \Hegyd\News\Services\NewsService;
use Carbon\Carbon;
use Hegyd\News\Repositories\Contracts\NewsCategoryRepositoryInterface;
use Hegyd\News\Repositories\Contracts\NewsRepositoryInterface;
// use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use App\Http\Controllers\Traits\Uploadable;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AbstractBackendController;
use App\Http\Controllers\Admin\AbstractAdminController;
use Illuminate\Support\Facades\DB;
use App\Models\Common\NewsCategory;


class NewsController extends AbstractBackendController
{
    use Uploadable;

    public function __construct(Request $request, NewsRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    public function configure()
    {
        $table = config('hegyd-news.tables.news');
        $categories_table = config('hegyd-news.tables.news_category');
        $users_table = config('hegyd-news.tables.users');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-news.routes.backend.prefix.news'),
                'lang'  => 'hegyd-news::news.',
                'view'  => 'hegyd-news::backend.news.',
                'acl'   => config('hegyd-news.permissions.prefix.backend.news'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'name',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.name',
                $table . '.category_id',
                $table . '.author_id',
                $table . '.created_at',
                DB::raw("CONCAT(users.firstname,' ',users.lastname) AS fullname"),
                $users_table . '.firstname as firstname',
                $users_table . '.lastname as lastname',
                $categories_table . '.name as category_name',
                $categories_table . '.active as category_active',
            ],
            'left_join'        => [
                [$categories_table, $table . '.category_id', '=', $categories_table . '.id'],
                [$users_table, $table . '.author_id', '=', $users_table . '.id'],
            ],
            // the columns configuration
            'columns'          => [
                'name'          => [
                    'title'     => 'hegyd-news::news.field.name',
                    'type'      => 'text',
                    'filterKey' => $table . '.name',
                    'route'     => config('hegyd-news.routes.backend.news.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                    'class'     => 'col-md-3',
                    'class_row' => 'text-left',
                ],
                'category_name' => [
                    'title'         => 'hegyd-news::news.field.category',
                    'type'          => 'select',
                    'listPopulator' => 'populateCategories',
                    'filterKey'     => $table . '.category_id',
                    'route'         => config('hegyd-news.routes.backend.news_category.edit'),
                    'route_id'      => 'category_id',
                    'callBack'      => 'printLink',
                    'class'         => 'col-md-3',
                    'class_row'     => 'text-left',
                ],
                'fullname' => [
                    'title'         => 'hegyd-news::news.field.author',
                    'type'          => 'select',
                    'listPopulator' => 'populateAuthors',
                    'filterKey'     => $table . '.author_id',
                    'route'         => config('hegyd-news.routes.backend.users.edit'),
                    'route_id'      => 'author_id',
                    'callBack'      => 'printLink',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                'created_at'          => [
                    'title'     => 'hegyd-news::news.field.created_at',
                    'type'      => 'date',
                    'filterKey' =>  $table . '.created_at',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }

    public function populateAuthors()
    {
        return app(NewsService::class)->populateAuthor();
    }

    public function configureUploads()
    {
        return [
            'visual' => [
                'type'        => 'image',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ],
            'visualSlider' => [
                'type'        => 'image',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_SECOND_VISUAL,
            ],
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.categories',
            'route'          => config('hegyd-news.routes.backend.news_category.index'),
            'complete_route' => true,
            'class'          => 'btn-danger',
            'icon_class'     => 'fa fa-list',
        ];

        return parent::index();
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }

        if ( ! isset($datas['display_on_slider']))
        {
            $datas['display_on_slider'] = false;
        }

        /*if (isset($datas['start_at']))
        {
            if ($datas['start_at'])
            {
                $datas['start_at'] = Carbon::createFromFormat('d/m/Y', $datas['start_at']);
            } else
            {
                $datas['start_at'] = null;
            }
        }

        if (isset($datas['end_at']))
        {
            if ($datas['end_at'])
            {
                $datas['end_at'] = Carbon::createFromFormat('d/m/Y', $datas['end_at']);
            } else
            {
                $datas['end_at'] = null;
            }
        }*/

        if ( ! $datas['author_id'])
        {
            $datas['author_id'] = auth()->user()->id;
        }

        /*if(config('hegyd-news.enable_comment')) {
            if ( ! isset($datas['enable_comment']))
            {
                $datas['enable_comment'] = false;
            }
        }*/

        return $datas;
    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        $role_ids = $this->getRequest()->get('role_ids', []);
        $model->roles()->sync($role_ids);

        return $model;
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        // $vars['categories'] = app(NewsCategoryRepositoryInterface::class)->pluck('name', 'id');
        $vars['categories'] = NewsCategory::where('active', true)->pluck('name', 'id')->toArray();

        $vars['category_selected'] = null;

        $vars['authors'] = app(config('hegyd-news.services.news'))->populateAuthor();

        $vars['author_selected'] = auth()->user()->id;

        if ($this->getRequest()->has('category_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('category_id');
        }

        return $vars;
    }

    public function populateCategories()
    {
        return app(NewsCategoryRepositoryInterface::class)->order('name')->pluck('name', 'id');
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }
}
