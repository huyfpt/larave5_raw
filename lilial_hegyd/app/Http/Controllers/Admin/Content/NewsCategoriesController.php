<?php

namespace App\Http\Controllers\Admin\Content;


use App\Models\Common\NewsCategory;
use Hegyd\News\Repositories\Contracts\NewsCategoryRepositoryInterface;
// use Hegyd\Uploads\Controllers\Traits\Uploadable;
use App\Http\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AbstractBackendController;

/**
 * Class NewsCategoriesController
 * @package Hegyd\News\Controllers\Backend
 */
class NewsCategoriesController extends AbstractBackendController
{

    use Uploadable;

    public function __construct(Request $request, NewsCategoryRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-news.tables.news_category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-news.routes.backend.prefix.news_category'),
                'lang'  => 'hegyd-news::news_categories.',
                'view'  => 'hegyd-news::backend.categories.',
                'acl'   => config('hegyd-news.permissions.prefix.backend.news_category'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'name',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.name',
                $table . '.parent_id',
            ],
            // the columns configuration
            'columns'          => [
                'name'   => [
                    'title'     => 'hegyd-news::news_categories.field.name',
                    'type'      => 'text',
                    'filterKey' => 'name',
                    'class_row' => 'text-left',
                ],
                'id'     => [
                    'title'                 => 'hegyd-news::news_categories.field.news',
                    'type'                  => 'text',
                    'callBack'              => 'printCount',
                    'relation'              => 'news',
                    'relation_route'        => config('hegyd-news.routes.backend.news.index'),
                    'relation_route_params' => [
                        'news___category_id' => 'id'
                    ],
                    'orderable'             => false,
                    'class'                 => 'col-md-1',
                    'class_row'             => 'text-center',
                ],
                'active' => [
                    'title'     => 'hegyd-news::news_categories.field.status',
                    'type'      => 'bool',
                    'filterKey' => 'active',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
            ],
        ];
    }

    public function configureUploads()
    {
        return [
            'visual' => [
                'type'       => 'image',
                'relation'   => Upload::RELATION_UNIQUE,
                'visibility' => Upload::VISIBILITY_PUBLIC,
            ]
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.news',
            'route'          => config('hegyd-news.routes.backend.news.index'),
            'complete_route' => true,
            'class'          => 'btn-danger',
            'icon_class'     => 'fa fa-list',
        ];

        return parent::index();
    }

    public function createFromModal()
    {
        if ( ! $this->acl('create'))
        {
            abort(401);
        }

        $category = new NewsCategory();

        $this->validate($this->getRequest(), [
            'name' => 'required|unique:' . config('hegyd-news.tables.news_category') . ',name|max:50',
        ]);

        $datas = $this->beforeSave($this->getRequest()->all(), $category);

        $category->fill($datas);

        $this->repository->save($category->getAttributes());

        $model = $this->repository->getModel();

        return $this->successJsonResponse(200, ['entity' => $model]);
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }
        // $datas['name'] = NewsCategory::processName($datas['parent_id'], $datas['name']);

        return $datas;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['categories'] = app(NewsCategoryRepositoryInterface::class)->pluck('name', 'id');

        $vars['categories'][0] = 'Root';
        ksort($vars['categories']);

        $vars['category_selected'] = null;

        $vars['authors'] = app(config('hegyd-news.services.news'))->populateAuthor();

        $vars['author_selected'] = auth()->user()->id;

        if ($this->getRequest()->has('category_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('category_id');
        }

        return $vars;
    }
}