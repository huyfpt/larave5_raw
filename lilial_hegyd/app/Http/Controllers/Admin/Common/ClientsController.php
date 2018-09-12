<?php

namespace App\Http\Controllers\Admin\Common;

use App\Events\Logs\Auth\LoginAsEvent;
use App\Events\Logs\Auth\LogoutAsEvent;
use App\Http\Controllers\Admin\AbstractAdminController;
use App\Http\Controllers\Traits\Addressable;
use App\Http\Controllers\Traits\Uploadable;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use App\Services\ACL\RoleService;
use App\Services\Common\ExtranetService;
use App\Services\Common\ClientService;
use App\Services\Common\UserService;
use App\Services\Notification\NotificationService;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Repositories\Contracts\Common\ClientRepositoryInterface;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Common\User;
use App\Models\Common\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Common\City;

class ClientsController extends AbstractAdminController
{
    use Uploadable, Addressable;

    protected $bulkActions = [
        'excel',
        'import-excel',
        // 'active',
        // 'unactive'
    ];

    public function __construct(
        Request $request,
        ClientRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    )
    {
        parent::__construct($request, $repository);

        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * configure the view
     * @return  array
     */
    protected function configure()
    {
        $data = [
            'rows_actions_template' => 'includes.datatable.actions',
            // the prefix for the view routing, lang and view
            'prefixes'              => [
                'route' => 'admin.clients.',
                'lang'  => 'clients.',
                'view'  => 'app.contents.admin.clients.',
                'acl'   => 'admin.clients.',
            ],
            'views'                 => [
                // the default template for datatable view
                'index' => 'index',
            ],
            // the field of the model that will be used for construct the edit view's title (breadcrumb, main title)
            'edit_object_name'      => 'id',
            // the select fields used when retrieving rows
            'select'                => [
                'clients.user_id',
                'clients.id',
                'users.firstname',
                'users.lastname',
                'users.civility',
                'users.username',
                'users.email',
                // 'users.password',
                'users.phone',
                'users.mobile',
                // 'users.creator_id',
                'users.newsletter',
                'roles.display_name as role_name',
                'clients.type',
                'clients.club_lilial',
                'clients.ambassador',
                'users.active',
                'clients.created_at',
            ],
            'left_join'             => [
                ['users', 'clients.user_id' , '=', 'users.id'],
                ['roles', 'users.role_id', '=', 'roles.id'],
            ],
            // the columns configuration
            'columns'               => [
                'firstname' => [
                    'title'     => 'users.fields.firstname',
                    'type'      => 'text',
                    'filterKey' => 'users.firstname',
                    'class_row' => 'text-left',
                ],
                'lastname'  => [
                    'title'     => 'users.fields.lastname',
                    'type'      => 'text',
                    'filterKey' => 'users.lastname',
                    'class_row' => 'text-left',
                ],
                'email'  => [
                    'title'     => 'users.fields.email',
                    'type'      => 'text',
                    'filterKey' => 'users.email',
                    'class_row' => 'text-left',
                ],
                'active'    => [
                    'title'     => 'users.fields.active',
                    'type'      => 'bool',
                    'filterKey' => 'users.active',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
                'club_lilial' => [
                    'title'     => 'clients.fields.club_lilial',
                    'type'      => 'bool',
                    'filterKey' => 'clients.club_lilial',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
                'ambassador' => [
                    'title'     => 'clients.fields.ambassador',
                    'type'      => 'bool',
                    'filterKey' => 'clients.ambassador',
                    'callBack'  => 'printStatus2',
                    'class_row' => 'text-center',
                ],
                /*'type' => [
                    'title'         => 'clients.fields.type',
                    'type'          => 'select',
                    'listPopulator' => 'populateTypes',
                    'filterKey'     => 'clients.type',
                    'class'         => 'col-md-2',
                    'class_row'     => 'text-center',
                ],*/
            ],
            'export'                => [
                'excludeFields' => [
                    'UTILISATEUR ID',
                    'CLIENT ID',
                    'PRÉNOM',
                    'NOM DE FAMILLE',
                    'CIVILITÉ',
                    'NOM D\'UTILISATEUR',
                    'EMAIL',
                    // 'MOT DE PASSE',
                    'TÉLÉPHONE',
                    'MOBILE',
                    // 'CRÉATEUR',
                    'NEWSLETTER',
                    'RÔLE',
                    'TYPE',
                    'CLUB',
                    'AMBASSADEUR',
                    'STATUT',
                    'CRÉÉ À',
                ],
                'joinFields'    => [
                    'users',
                    'roles',
                ],
            ],
        ];

        return $data;
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

    protected function populateTypes()
    {
        return ['user' => 'User', 'professional' => 'Professional'];
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
        if ( ! isset($datas['club_lilial']))
        {
            $datas['club_lilial'] = false;
        }
        if ( ! isset($datas['type']))
        {
            $datas['type'] = 'user';
        }

        if (isset($datas['password']) && $datas['password'])
        {
            $datas['password_clear'] = $datas['password'];
            $datas['password'] = bcrypt($datas['password']);
        } else
        {
            unset($datas['password']);
        }
        
        if ( ! isset($datas['role_id']))
        {
            $datas['role_id'] = User::ROLE_CLIENT;
        }

        if(isset($datas['phone']))
        {
            $datas['phone'] = str_replace([' ', '-', '.'], '', str_replace('+33', '0', $datas['phone']));
        }

        if(isset($datas['mobile']))
        {
            $datas['mobile'] = str_replace([' ', '-', '.'], '', str_replace('+33', '0', $datas['mobile']));
        }

        if(empty($model))
        {
            // save User
            $user = Client::storeUser($datas);
            $datas['user_id'] = $user->id;

        } else
        {
            // update User
            $user_id = $model->user_id;
            Client::updateUser($user_id, $datas);

        }
        return $datas;

    }

    protected function afterSave(Model $model, $data = [])
    {
        parent::afterSave($model->user, $data);

        return $model;
    }

    public function destroy($id)
    {
        // delete User
        Client::deleteUser($id);

        return $this->executeDelete($id);
    }

    protected function viewVars()
    {
        $vars = parent::viewVars();

        $vars['post_code'] = $this->getPostCode();

        return $vars;
    }

    public function getPostCode()
    {
        $post_code = City::select('zip')->distinct('zip')->limit(20)->pluck('zip');

        return $post_code;
    }

    public function ajaxPostCode(Request $request)
    {
        $keyword = $request->get('q');

        $query = City::select('zip')->distinct('zip');
        if (!empty($keyword)) {
            $post_code = $query->where('zip', 'LIKE', '%'.$keyword.'%')->limit(20)->pluck('zip');
        }
        else
        {
            $post_code = $this->getPostCode();
        }

        if(!empty($post_code))
        {
            $post_code = $post_code->map(function ($item) {
                return ['id' => $item, 'text' => $item];
            });
        }

        return $post_code;
    }
    
}
