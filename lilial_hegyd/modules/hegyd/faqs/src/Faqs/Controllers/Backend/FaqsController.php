<?php
/**
 * FaqsController class
 *
 * Handle Faq logic.
 * @category   FaqsController
 * @package    Hegyd\Faqs\Controllers\Backend
 * @author     Do Viet Hung <hungdv@dfm-engineering.com>
 * @copyright  2018 Hegyd
 * @license    www.hegyd.com
 * @version    1.0.0
 * @since      Class available since Release 1.0
 */
namespace Hegyd\Faqs\Controllers\Backend;

use Carbon\Carbon;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FaqsController extends AbstractBackendController
{

    use Uploadable;

    public function __construct(Request $request, FaqsRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-faqs.tables.faqs');
        $categories_table = config('hegyd-faqs.tables.faqs_category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-faqs.routes.backend.prefix.faqs'),
                'lang'  => 'hegyd-faqs::faqs.',
                'view'  => 'hegyd-faqs::backend.faqs.',
                'acl'   => config('hegyd-faqs.permissions.prefix.backend.faqs'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'title',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.title',
                $table . '.slug',
                $table . '.content',
                $table . '.meta_title',
                $table . '.meta_description',
                $table . '.meta_keyword',
                $table . '.status',
                $table . '.start_at',
                $table . '.end_at',
                $table . '.category_id',
                $table . '.author_id',
                $categories_table . '.label as category_name',
                $categories_table . '.status as category_active',
            ],
            'left_join'        => [
                [$categories_table, $table . '.category_id', '=', $categories_table . '.id'],
            ],
            // the columns configuration
            'columns'          => [
                'title'          => [
                    'title'     => 'hegyd-faqs::faqs.field.title',
                    'type'      => 'text',
                    'filterKey' => $table . '.title',
                    'class_row' => 'text-left',
                    'callBack'  => 'printLink',
                    'route_id'  => 'id',
                    'class'     => 'col-md-4',
                    'filterKey' => $table . '.title',
                    'route'     => config('hegyd-faqs.routes.backend.faqs.edit'),
                ],
                'category_name' => [
                    'title'         => 'hegyd-faqs::faqs.field.category',
                    'type'          => 'select',
                    'listPopulator' => 'populateCategories',
                    'filterKey'     => $table . '.category_id',
                    'route'         => config('hegyd-faqs.routes.backend.faqs_category.edit'),
                    'route_id'      => 'category_id',
                    'callBack'      => 'printLink',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                
                'status'        => [
                    'title'     => 'hegyd-faqs::faqs.field.status',
                    'type'      => 'bool',
                    'filterKey' => $table . '.status',
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
                'type'        => 'image',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ],
            'visualDocument' => [
                'type'        => 'pdf',
                'relation'    => Upload::RELATION_UNIQUE,
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_DOCUMENTS,
                'maxSize'     => 150000
            ],
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.categories',
            'route'          => config('hegyd-faqs.routes.backend.faqs_category.index'),
            'complete_route' => true,
            'class'          => 'btn-danger',
            'icon_class'     => 'fa fa-list',
        ];
        
        return parent::index();
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['status']))
        {
            $datas['status'] = false;
        }

        if (isset($datas['start_at']))
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
        }

        if ( ! $datas['author_id'])
        {
            $datas['author_id'] = auth()->user()->id;
        }


        return $datas;
    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);
        
        // $role_ids = $this->getRequest()->get('role_ids', []);
        // $model->roles()->sync($role_ids);

        return $model;
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['categories'] = app(FaqsCategoryRepositoryInterface::class)->pluck('label', 'id');

        $vars['category_selected'] = null;

        $vars['authors'] = app(config('hegyd-faqs.services.faqs'))->populateAuthor();

        $vars['author_selected'] = auth()->user()->id;

        if ($this->getRequest()->has('category_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('category_id');
        }

        return $vars;
    }

    public function populateCategories()
    {
        return app(FaqsCategoryRepositoryInterface::class)->order('label')->pluck('label', 'id');
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }


    public function ajaxListFaq()
    {
        $id = $this->getRequest()->get('id');
        $keyword = $this->getRequest()->get('q');

        return $this->getRepository()->ajaxListFaq($id, $keyword);
    }
    
    public function toggleActive($id)
    {
        if ( ! $this->acl('edit'))
        {
            abort(401);
        }

        $datas  = [];
        $datas['status'] = $this->getRequest()->get('state', false);

        $this->getRepository()->updateRich($datas, $id);

    }

}