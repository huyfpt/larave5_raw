<?php namespace Hegyd\Permissions\Seeders;

use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Illuminate\Database\Seeder;

class BasePermissionsSeeder extends AsbtractPermissionsRolesSeeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ADMIN ROOT CATEGORY
         */
        $adminCategoryKey = 'admin';
        $adminCategoryId = null;
        $adminCategory = CategoryPermission::where('key', $adminCategoryKey)->first();

        if ($adminCategory)
        {
            $adminCategoryId = $adminCategory->id;
        } else
        {
            $adminCategory = CategoryPermission::create([
                'name' => 'Administration',
                'key'  => $adminCategoryKey,
            ]);
            $adminCategoryId = $adminCategory->id;
        }


        /**
         * ADMIN PERMISSION CATEGORY
         */
        $adminPermissionCategoryKey = 'admin.permission';
        $adminPermissionCategoryId = null;
        $adminPermissionCategory = CategoryPermission::where('key', $adminPermissionCategoryKey)->first();

        if ($adminPermissionCategory)
        {
            $adminPermissionCategoryId = $adminPermissionCategory->id;
        } else
        {
            $adminPermissionCategory = CategoryPermission::create([
                'name'      => 'Gestion des permissions',
                'key'       => $adminPermissionCategoryKey,
                'parent_id' => $adminCategoryId,
            ]);
            $adminPermissionCategoryId = $adminPermissionCategory->id;
        }

        /**
         * PERMISSIONS
         */

        if (Permission::where("name", "admin.permission.view")->first() == null)
        {
            $permission = Permission::create([
                'name'         => 'admin.permission.view',
                'display_name' => 'Accéder à l\'interface des permissions',
                'category_id'  => $adminPermissionCategoryId,
            ]);
        }

        if (Permission::where("name", "admin.permission.edit")->first() == null)
        {
            $permission = Permission::create([
                'name'         => 'admin.permission.edit',
                'display_name' => 'Accéder à l\'interface des permissions',
                'category_id'  => $adminPermissionCategoryId,
            ]);
        }

        /**
         * ATTACH PERMISSION TO ROLES
         */
        $this->attachPermissionToRoles("admin.permission.view", array(self::ROLE_SUPERADMIN, self::ROLE_ADMIN));
        $this->attachPermissionToRoles("admin.permission.edit", array(self::ROLE_SUPERADMIN, self::ROLE_ADMIN));

    }
}
