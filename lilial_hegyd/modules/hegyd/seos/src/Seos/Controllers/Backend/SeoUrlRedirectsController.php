<?php

namespace Hegyd\Seos\Controllers\Backend;
 
use Carbon\Carbon;
use Hegyd\Seos\Models\SeoUrlRedirects;
use Hegyd\Seos\Repositories\Contracts\SeoUrlRedirectsRepositoryInterface;
use Hegyd\Uploads\Controllers\Traits\Uploadable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
 
class SeoUrlRedirectsController extends AbstractBackendController
{
    
    public function __construct(Request $request, SeoUrlRedirectsRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        $table = config('hegyd-seos.tables.seo_url_redirects');

        return [
            // the prefix for the view routing, lang and view
            'prefixes'         => [
                'route' => config('hegyd-seos.routes.backend.prefix.seo_url_redirects'),
                'lang'  => 'hegyd-seos::seo_url_redirects.',
                'view'  => 'hegyd-seos::backend.seo_url_redirects.',
                'acl'   => config('hegyd-pages.permissions.prefix.backend.pages'),
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name' => 'title',
            // the select fields used when retrieving rows
            'select'           => [
                $table . '.id',
                $table . '.active',
                $table . '.new_url',
                $table . '.old_url',
            ],
            // the columns configuration
            'columns'          => [
                'new_url'          => [
                    'title'     => 'hegyd-seos::seo_url_redirects.field.new_url',
                    'type'      => 'text',
                    'filterKey' => $table . '.new_url',
                    'class'     => 'col-md-4',
                    'class_row' => 'text-left',
                ],
                'old_url'          => [
                    'title'     => 'hegyd-seos::seo_url_redirects.field.old_url',
                    'type'      => 'text',
                    'filterKey' => $table . '.old_url',
                    'class'     => 'col-md-4',
                    'class_row' => 'text-left',
                ],
                
                'active'          => [
                    'title'         => 'hegyd-seos::seo_url_redirects.field.active',
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
            'label'          => 'button.seos',
            'route'          => config('hegyd-seos.routes.backend.seos.index'),
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

        return $datas;

    }

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        $this->getRepository()->updateHtaccess();

        return $model;
    }


    public function populateVisible()
    {
        $visible = ['Privé', 'Public'];
        return $visible;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }
}