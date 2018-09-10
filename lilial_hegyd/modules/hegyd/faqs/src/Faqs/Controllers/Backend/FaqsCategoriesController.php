<?php
/**
 * FaqsCategoriesController class
 *
 * @category   FaqsCategoriesController
 * @package    Hegyd\Faqs\Controllers\Backend
 * @author     Do Viet Hung <hungdv@dfm-engineering.com>
 * @copyright  2018 Hegyd
 * @license    www.hegyd.com
 * @version    1.0.0
 * @since      Class available since Release 1.0
 */
namespace Hegyd\Faqs\Controllers\Backend;


use Hegyd\Faqs\Models\FaqsCategory;
use Hegyd\Faqs\Repositories\Contracts\FaqsCategoryRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FaqsCategoriesController extends AbstractBackendController
{

    use Uploadable;

    public function __construct(Request $request, FaqsCategoryRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-faqs.tables.faqs_category');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-faqs.routes.backend.prefix.faqs_category'),
                'lang'  => 'hegyd-faqs::faqs_categories.',
                'view'  => 'hegyd-faqs::backend.categories.',
                'acl'   => config('hegyd-faqs.permissions.prefix.backend.faqs_category'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'label',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.label',
                $table . '.introduction',
                $table . '.parent_id',
                $table . '.status',
            ],
            // the columns configuration
            'columns'          => [
                // 'id'     => [
                //     'title'                 => 'hegyd-faqs::faqs_categories.field.id',
                //     'type'                  => 'text',
                //     'filterKey' => 'id',
                //     'orderable'             => false,
                //     'class'                 => 'col-md-1',
                //     'class_row' => 'text-center',
                // ],
                'label'   => [
                    'title'     => 'hegyd-faqs::faqs_categories.field.label',
                    'type'      => 'text',
                    'filterKey' => 'label',
                    'class_row' => 'text-left',
                ],
                
                // 'parent_id'     => [
                //     'title'                 => 'hegyd-faqs::faqs_categories.field.parent_id',
                //     'type'                  => 'text',
                //     'filterKey'             => 'parent_id',
                //     // 'relation'              => 'parent',
                //     // 'relation_route'        => config('hegyd-faqs.routes.backend.faqs.index'),
                //     // 'relation_route_params' => [
                //     //     'faqs_categories___parent_id' => 'id'
                //     // ],
                //     'orderable'             => false,
                //     'class'                 => 'col-md-1',
                //     'class_row' => 'text-center',
                // ],
                
                
                'status' => [
                    'title'     => 'hegyd-faqs::faqs_categories.field.status',
                    'type'      => 'bool',
                    'filterKey' => 'status',
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
            'label'          => 'button.faqs',
            'route'          => config('hegyd-faqs.routes.backend.faqs.index'),
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

        $category = new FaqsCategory();

        $this->validate($this->getRequest(), [
            'label' => 'required|unique:' . config('hegyd-faqs.tables.faqs_category') . ',label|max:255',
        ]);

        $datas = $this->beforeSave($this->getRequest()->all(), $category);

        $category->fill($datas);

        $this->repository->save($category->getAttributes());

        $model = $this->repository->getModel();

        return $this->successJsonResponse(200, ['entity' => $model]);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['categories'] = app(FaqsCategoryRepositoryInterface::class)->pluck('label', 'id as parent_id');

        $vars['categories']['0'] = 'Catégorie root';

        $vars['category_selected'] = null;
        ksort($vars['categories']);
        if ($this->getRequest()->has('parent_id'))
        {
            $vars['category_selected'] = $this->getRequest()->get('parent_id');
        }

        return $vars;
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['status']))
        {
            $datas['status'] = false;
        }

        return $datas;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

}