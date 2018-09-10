<?php

namespace Hegyd\Seos\Controllers\Backend;
 
use Carbon\Carbon;
use Hegyd\Seos\Repositories\Contracts\SeosRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
 
class SeosController extends AbstractBackendController
{
    
    public function __construct(Request $request, SeosRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-seos.tables.seos');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-seos.routes.backend.prefix.seos'),
                'lang'  => 'hegyd-seos::seos.',
                'view'  => 'hegyd-seos::backend.seos.',
                'acl'   => config('hegyd-pages.permissions.prefix.backend.pages'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'title',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.title',
                $table . '.url',
                $table . '.created_at',
            ],
            // the columns configuration
            'columns'          => [
                'url'          => [
                    'title'     => 'hegyd-seos::seos.field.url',
                    'type'      => 'text',
                    'filterKey' => $table . '.url',
                    'class'     => 'col-md-4',
                    'class_row' => 'text-left',
                    'route'     => config('hegyd-seos.routes.backend.seos.edit'),
                    'route_id'  => 'id',
                    'callBack'  => 'printLink',
                ],
                
                'active'          => [
                    'title'         => 'hegyd-seos::seos.field.active',
                    'type'          => 'select',
                    'listPopulator' => 'populateVisible',
                    'filterKey'     => $table . '.active',
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
                'visibility'  => Upload::VISIBILITY_PUBLIC,
                'upload_type' => Upload::TYPE_MAIN_VISUAL,
            ]
        ];
    }

    public function index()
    {
        $this->moreActions[] = [
            'label'          => 'button.seo_url_redirects',
            'route'          => config('hegyd-seos.routes.backend.seo_url_redirects.index'),
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

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }
       
        return $datas;

    }

    protected function afterSave(Model $model, $data = [])
    {
        
        $model = parent::afterSave($model, $data);
        return $model;
    }


    public function populateVisible()
    {
        $visible = ['Inactif', 'Actif'];
        return $visible;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }
}