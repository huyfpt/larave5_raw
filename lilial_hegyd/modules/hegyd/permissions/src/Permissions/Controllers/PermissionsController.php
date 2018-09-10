<?php namespace Hegyd\Permissions\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


/**
 * Class LogsController
 * @package Hegyd\Logs\Controllers
 */
class PermissionsController extends Controller
{

    private $_roleClass;

    private $_categoryClass;

    private $_permissionClass;

    public function __construct()
    {
        $this->_roleClass = config('hegyd-permissions.role_model');
        $this->_categoryClass = config('hegyd-permissions.category_model');
        $this->_permissionClass = config('hegyd-permissions.permission_model');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();
        if ( ! $user != null || ! $user->can([config('hegyd-permissions.acl.index')]))
        {
            abort(403, trans('hegyd-permissions::permissions.message.access_denied'));
        }

        $roleClass = $this->_roleClass;
        $permissionClass = $this->_permissionClass;
        $categoryClass = $this->_categoryClass;

        $roles = $roleClass::orderBy('display_name')->get();
        $rootCategories = $categoryClass::whereNull('parent_id')->get();

        $perm_edit = Auth::user()->can([config('hegyd-permissions.acl.edit')]);
        $renderBread = null;

        return view('hegyd-permissions::index', compact('perm_edit', 'renderBread', 'roles', 'rootCategories'));

    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $services = $request->get('roles', null);

        $roleClass = $this->_roleClass;
        $permissionClass = $this->_permissionClass;
        $categoryClass = $this->_categoryClass;

        // Save new role's permissions
        if ($services)
        {
            $allRoles = $roleClass::all();
            foreach ($allRoles as $role)
            {
                $permissionsSync = [];
                if (isset($services[$role->id]))
                {
                    $serviceData = $services[$role->id];
                    foreach ($serviceData['permissions'] as $permissionId => $permissionData)
                    {
                        $permissionsSync[] = $permissionId;
                    }
                }
                $role->perms()->sync($permissionsSync);
            }
        }

        return redirect()->route(config('hegyd-permissions.routes.index'))
            ->with('message', trans('hegyd-permissions::permissions.message.perms_changed'));
    }

}