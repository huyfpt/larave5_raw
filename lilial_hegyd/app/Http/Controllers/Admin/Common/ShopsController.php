<?php namespace App\Http\Controllers\Admin\Common;

use App\Facades\AppTools;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\Addressable;
use App\Http\Controllers\Traits\Uploadable;
use App\Models\Common\Shop;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class ShopsController extends AbstractAdminController
{

    use Addressable, Uploadable;

    protected $bulkActions = [
        'excel',
        'active',
        'unactive',
    ];

    public function __construct(Request $request, ShopRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    /**
     * configure the view
     * @return  array
     */
    protected function configure()
    {
        return [
            // the prefix for the view routing, lang and view
            'prefixes'              => [
                'route' => 'admin.shops.',
                'lang'  => 'shops.',
                'view'  => 'app.contents.admin.shops.',
                'acl'   => 'admin.shops.',
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name'      => 'name',
            // the select fields used when retrieving rows
            'select'                => [
                'shops.id',
                'shops.active',
                'shops.name as shop_name',
                'shops.client_code',
                'shops.client_code',
                'addresses.zip',
                'shops.created_at',
            ],
            'left_join'                  => [
                ['addresses', function ($join) {
                    $join->on('addresses.addressable_id', '=', 'shops.id')
                        ->where('addresses.addressable_type', '=', Shop::class);
                }],
            ],
            // the columns configuration
            'columns'               => [
                'shop_name' => [
                    'title'     => 'shops.fields.name',
                    'type'      => 'text',
                    'filterKey' => 'shops.name',
                    'class'     => 'col-md-3',
                    'class_row' => 'text-left',
                ],
                'client_code'  => [
                    'title'     => 'shops.fields.client_code',
                    'type'      => 'text',
                    'filterKey' => 'client_code',
                    'class'     => 'col-md-3',
                    'class_row' => 'text-left',
                ],
                'zip'     => [
                    'title'     => 'addresses.fields.zip',
                    'type'      => 'text',
                    'filterKey' => 'addresses.zip',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'active'    => [
                    'title'     => 'shops.fields.active',
                    'type'      => 'bool',
                    'filterKey' => 'shops.active',
                    'callBack'  => 'printStatus2',
                    'class'     => 'col-md-1',
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

    protected function beforeSave(array $datas, Model $model = null)
    {

        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['head_office']))
        {
            $datas['head_office'] = false;
        }

        $current_company = AppTools::currentCompany();
        $datas['company_id'] = $current_company->id;

        return $datas;

    }

    public function configureAddresses()
    {
        return ['address' => []];
    }


    public function showMulti($ids = null)
    {
        $results = [];

        if ($ids)
        {
            $ids = explode(',', $ids);

            foreach ($ids as $id)
            {
                $r = $this->repository->find($id);
                if ($r)
                {
                    $results[] = $r;
                }
            }
        }

        return $results;
    }

    public function searchAjax()
    {
        $query = $this->getRequest()->get('query');
        $shops = $this->repository->findByTermAndRole($query, null, 10);

        return $shops;
    }

    public function destroy($id)
    {
        return $this->executeDelete($id);
    }

}