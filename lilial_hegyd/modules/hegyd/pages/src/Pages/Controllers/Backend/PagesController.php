<?php

namespace Hegyd\Pages\Controllers\Backend;
 
use Carbon\Carbon;
use Hegyd\Pages\Repositories\Contracts\PagesRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use App\Http\Controllers\Traits\Addressable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
 
class PagesController extends AbstractBackendController
{
    use Addressable, Uploadable;

    public function __construct(Request $request, PagesRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-pages.tables.pages');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-pages.routes.backend.prefix.pages'),
                'lang'  => 'hegyd-pages::pages.',
                'view'  => 'hegyd-pages::backend.pages.',
                'acl'   => config('hegyd-pages.permissions.prefix.backend.pages'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'title',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.description',
                $table . '.content',
                $table . '.title',
                $table . '.status',
                $table . '.user_id',
                $table . '.updated_at',
                $table . '.created_at',
            ],
            // the columns configuration
            'columns'          => [
                'title'          => [
                    'title'     => 'hegyd-pages::pages.field.title',
                    'type'      => 'text',
                    'filterKey' => $table . '.title',
                    'class'     => 'col-md-3',
                    'class_row' => 'text-left',
                    'route'     => config('hegyd-pages.routes.backend.pages.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                ],
                'status'          => [
                    'title'     => 'hegyd-pages::pages.field.status',
                    'type'      => 'select',
                    'filterKey' => $table . '.status',
                    'class'     => 'col-md-3',
                    'class_row' => 'text-left',
                    'listPopulator' => 'populateStatus',
                    'callBack'      => 'printVisible',
                    'class'         => 'col-md-1',
                    'class_row'     => 'text-center',
                ],
            ],
        ];
    }

    public function configureAddresses()
    {
        return ['address' => []];
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
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.pages',
            'route'          => config('hegyd-pages.routes.backend.pages.index'),
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

        if (isset($datas['created_at']))
        {
            if ($datas['created_at'])
            {
                $datas['created_at'] = Carbon::createFromFormat('d/m/Y', $datas['created_at']);
            } else
            {
                $datas['created_at'] = null;
            }
        }

        if (isset($datas['updated_at']))
        {
            if ($datas['updated_at'])
            {
                $datas['updated_at'] = Carbon::createFromFormat('d/m/Y', $datas['updated_at']);
            } else
            {
                $datas['updated_at'] = null;
            }
        }

        if ( ! $datas['user_id'])
        {
            $datas['user_id'] = auth()->user()->id;
        }


        return $datas;
    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        return $model;
    }
 
    public function populateStatus()
    {
        $visible = ['Inactif','Actif'];
        return $visible;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }
}