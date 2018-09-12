<?php namespace App\Http\Controllers\Admin\Common;

use App\Events\Logs\Auth\LoginAsEvent;
use App\Events\Logs\Auth\LogoutAsEvent;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\Addressable;
use App\Http\Controllers\Traits\Uploadable;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Repositories\Contracts\Common\ShopRepositoryInterface;
use App\Services\ACL\RoleService;
use App\Services\Common\ExtranetService;
use App\Services\Common\ShopService;
use App\Services\Common\UserService;
use App\Services\Notification\NotificationService;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Common\User;
use App\Models\Common\Client;
use App\Models\Common\City;


class UsersController extends AbstractAdminController
{

    use Uploadable, Addressable;

    protected $bulkActions = [
        // 'excel',
        // 'active',
        // 'unactive',
        // 'forceResetPassword'
    ];

    public function __construct(
        Request $request,
        UserRepositoryInterface $repository,
        RoleRepositoryInterface $roleRepository,
        ShopRepositoryInterface $shopRepository
    )
    {
        parent::__construct($request, $repository);

        $this->roleRepository = $roleRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * configure the view
     * @return  array
     */
    protected function configure()
    {
        return [
            'rows_actions_template' => 'includes.datatable.actions',
            // the prefix for the view routing, lang and view
            'prefixes'              => [
                'route' => 'admin.users.',
                'lang'  => 'users.',
                'view'  => 'app.contents.admin.users.',
                'acl'   => 'admin.users.',
            ],
            'views'                 => [
                // the default template for datatable view
                'index' => 'index',
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name'      => 'firstname',
            // the select fields used when retrieving rows
            'select'                => [
                'users.id',
                'users.username',
                'users.firstname',
                'users.lastname',
                'users.civility',
                'users.email',
                'users.password',
                'users.phone',
                'users.mobile',
                'users.creator_id',
                'users.updator_id',
                'users.newsletter',
                'users.created_at',
                'roles.display_name as role_name',
                'users.active',
            ],
            'left_join'             => [
                ['shop_user', 'shop_user.user_id', '=', 'users.id'],
                ['shops', 'shop_user.shop_id', '=', 'shops.id'],
                ['roles', 'users.role_id', '=', 'roles.id'],
            ],
            // the columns configuration
            'columns'               => [
                'firstname' => [
                    'title'     => 'users.fields.firstname',
                    'type'      => 'text',
                    'filterKey' => 'users.firstname',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'lastname'  => [
                    'title'     => 'users.fields.lastname',
                    'type'      => 'text',
                    'filterKey' => 'users.lastname',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'email'  => [
                    'title'     => 'users.fields.email',
                    'type'      => 'text',
                    'filterKey' => 'users.email',
                    'class'     => 'col-md-2',
                    'class_row' => 'text-left',
                ],
                'role_name' => [
                    'title'         => 'users.fields.roles',
                    'type'          => 'select',
                    'listPopulator' => 'populateRoles',
                    'filterKey'     => 'roles.id',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],
                /*'shop_name' => [
                    'title'         => 'users.fields.shops',
                    'type'          => 'select',
                    'listPopulator' => 'populateShops',
                    'filterKey'     => 'shops.id',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-left',
                ],*/
                'active'    => [
                    'title'     => 'users.fields.active',
                    'type'      => 'bool',
                    'filterKey' => 'users.active',
                    'callBack'  => 'printStatus2',
                    'class'     => 'col-md-1',
                    'class_row' => 'text-center',
                ],
            ],
            'bulk'                  => [
                'forceResetPassword' => [
                    'route'         => 'bulk.force-reset-password',
                    'icon'          => 'fas fa-lock',
                    'text'          => trans('users.buttons.forceResetPassword'),
                    'divider'       => true,
                    'confirm'       => true,
                    'confirm-title' => trans('users.confirms.bulk.forceResetPassword.title'),
                    'confirm-text'  => trans('users.confirms.bulk.forceResetPassword.text'),
                ],
            ],
            'export'                => [
                'excludeFields' => [
                    'users.id',
                    'users.username',
                    'users.firstname',
                    'users.lastname',
                    'users.civility',
                    'users.email',
                    'users.password',
                    'users.phone',
                    'users.mobile',
                    'users.creator_id',
                    'users.updator_id',
                    'users.newsletter',
                    'users.role_id',
                    'users.active',
                ],
                'joinFields'    => [
                    'roles'
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
                'type'       => 'image',
                'relation'   => Upload::RELATION_UNIQUE,
                'visibility' => Upload::VISIBILITY_PUBLIC,
            ]
        ];
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
        $users = $this->repository->findByTermAndRole($query, null, 10);

        return $users;
    }

    public function bulkForceResetPassword()
    {
        if ( ! $this->getRequest()->ajax() || ! $this->acl('edit'))
            abort(401);

        foreach ($this->getRequest()->get('ids') as $id)
        {
            $this->_forceResetPassword($id);
        }
    }

    public function forceResetPassword($id)
    {
        if ( ! $this->getRequest()->ajax() || ! $this->acl('edit'))
            abort(401);

        $this->_forceResetPassword($id);
    }

    private function _forceResetPassword($id)
    {
        $user = $this->repository->findOrFail($id);

        app(UserService::class)->forceResetPassword($user);
    }

    protected function beforeSave(array $datas, Model $model = null)
    {
        $datas = parent::beforeSave($datas);

        if ( ! isset($datas['active']))
        {
            $datas['active'] = false;
        }
        if ( ! isset($datas['display_directory']))
        {
            $datas['display_directory'] = false;
        }
        if ( ! isset($datas['user_head_office']))
        {
            $datas['user_head_office'] = false;
        }
        if ( ! isset($datas['ambassador']))
        {
            $datas['ambassador'] = false;
        }

        if (isset($datas['password']) && $datas['password'])
        {
            $datas['password_clear'] = $datas['password'];
            $datas['password'] = bcrypt($datas['password']);
        } else
        {
            unset($datas['password']);
        }
        if ( ! isset($datas['shop_id']))
        {
            $datas['shop_id'] = 1;
        }

        if(isset($datas['phone']))
        {
            $datas['phone'] = str_replace([' ', '-', '.'], '', str_replace('+33', '0', $datas['phone']));
        }

        if(isset($datas['mobile']))
        {
            $datas['mobile'] = str_replace([' ', '-', '.'], '', str_replace('+33', '0', $datas['mobile']));
        }

        return $datas;

    }

    protected function afterSave(Model $user, $data = [])
    {
        parent::afterSave($user, $data);

        if (isset($data['role_id']) && isset($data['shop_id']))
        {
            $user->shops()->sync([$data['shop_id'] => ["role_id" => $data['role_id']]]);
        }
        
        // delete client if change role
        if(User::checkRoleClient($user) == false)
        {
            User::deleteClient($user->id);
        }
        
        // save client
        User::storeClient($user, $data);


        return $user;
    }

    protected function customRedirect(array $datas, $model, $routePrefix)
    {
        $_action = null;
        if ( ! empty($datas['_action']))
        {
            $_action = $datas['_action'];
        }

        if ($_action == 'save-and-force-reset-password-btn')
        {
            app(UserService::class)->forceResetPassword($model);

            $this->notifyUpdated($this->trans('labels.forceResetPassword'));

            return redirect()->route($routePrefix . 'edit', ['id' => $model->id])->with('success_action', trans('app.success_action'));
        }

        return parent::customRedirect($datas, $model, $routePrefix);
    }


    public function destroy($id)
    {   
        // delete Client
        User::deleteClient($id);
        
        return $this->executeDelete($id);
    }

    public function loginAs($id)
    {
        $current_user = auth()->user();

        if ($current_user->hasRole(['super_admin', 'admin']))
        {
            $impersonate_user = $this->repository->find($id);
            if ($impersonate_user)
            {
                session()->put('impersonateId', \Crypt::encrypt($current_user->id));
                auth()->login($impersonate_user);
                app(ExtranetService::class)->renewUserVars();

                event(new LoginAsEvent($impersonate_user, $current_user));

                return redirect()->route('index');
            }
        }

        return redirect()->back();
    }

    public function logoutAs()
    {
        if (session()->has('impersonateId'))
        {
            $impersonate_user = auth()->user();
            $user = $this->repository->findOrFail(
                Crypt::decrypt(session()->get('impersonateId'))
            );
            auth()->login($user);
            session()->forget('impersonateId');
            app(ExtranetService::class)->renewUserVars();

            event(new LogoutAsEvent($impersonate_user, $user));

            return redirect()->route('admin.users.index');
        }

        return redirect()->back();

    }

    protected function populateShops()
    {
        return app(ShopService::class)->getSelectList();
    }

    protected function populateRoles()
    {
        return app(RoleService::class)->getSelectList();
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['cities'] = $this->getCities();

        return $vars;
    }

    public function getCities()
    {
        $cities = City::select('name')->distinct('name')->limit(20)->pluck('name');

        return $cities;
    }

    public function ajaxCities(Request $request)
    {
        $keyword = $request->get('q');

        $query = City::select('name')->distinct('name');
        if (!empty($keyword)) {
            $cities = $query->where('name', 'LIKE', '%'.$keyword.'%')->limit(20)->pluck('name');
        }
        else
        {
            $cities = $this->getCities();
        }

        if(!empty($cities))
        {
            $cities = $cities->map(function ($item) {
                return ['id' => $item, 'text' => $item];
            });
        }

        return $cities;
    }

}