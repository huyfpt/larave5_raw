<?php namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Traits\Breadcrumbable;
use App\Repositories\Contracts\ACL\RoleRepositoryInterface;
use \Hegyd\Permissions\Controllers\PermissionsController as Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{

    use Breadcrumbable;


    public function index()
    {
        $view = parent::index();

        $this->includeBreadcrumbs();

        $categoryClass = config('hegyd-permissions.category_model');

        $roles = app(RoleRepositoryInterface::class)->getAll();
        $rootCategories = $categoryClass::whereNull('parent_id');

        if ( ! auth()->user()->hasRole('super_admin'))
        {
            $rootCategories->where('key', 'not like', 'super%')->get();
        }

        $rootCategories = $rootCategories->get();

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $title = trans('hegyd-permissions::permissions.title.permissions');
        $this->breadcrumbs->addCrumb($title, config('hegyd-permissions.routes.index'));

        return $view->with('title', $title)
            ->with('roles', $roles)
            ->with('rootCategories', $rootCategories)
            ->with('breadcrumb', $this->breadcrumbs);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $services = $request->get('roles', null);

        // Save new role's permissions
        if ($services)
        {
            $allRoles = app(RoleRepositoryInterface::class)->getAll();
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

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        return [
            'namespace'   => '',
            'cssClass'    => 'breadcrumb',
            'divider'     => '',
            'listElement' => 'ol'
        ];
    }
}