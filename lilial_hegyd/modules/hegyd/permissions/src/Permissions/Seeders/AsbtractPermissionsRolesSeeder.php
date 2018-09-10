<?php

namespace Hegyd\Permissions\Seeders;

use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

abstract class AsbtractPermissionsRolesSeeder extends Seeder
{

    const ROLE_SUPERADMIN = "superadmin";
    const ROLE_ADMIN = "admin";

    protected $ALL_ROLES = [
        self::ROLE_SUPERADMIN,
        self::ROLE_ADMIN,
    ];


    /**
     * Attach the permission to all roles given
     * @param String $permissionName
     * @param Array $roles
     */
    protected function attachPermissionToRoles($permissionName, $roles)
    {
        $permission = Permission::where("name", "=", $permissionName)->first();
        if ($permission)
        {
            foreach ($roles as $k => $roleName)
            {
                $role = Role::where("name", "=", $roleName)->first();
                if ($role)
                {
                    if ( ! $role->hasPermission($permissionName))
                    {
                        $role->attachPermission($permission);
                    }
                }
            }
        }
    }

    /**
     * Attach the permission to all roles given
     * @param String $permissionName
     * @param String $roleName
     */
    protected function attachPermissionToRole($permissionName, $roleName)
    {
        $permission = Permission::where("name", "=", $permissionName)->first();
        if ($permission)
        {
            $role = Role::where("name", "=", $roleName)->first();
            if ($role)
            {
                if ( ! $role->hasPermission($permissionName))
                {
                    $role->attachPermission($permission);
                }
            }
        }
    }

    /**
     * Detach the permission to all roles given
     * @param String $permissionName
     * @param Array $roles
     */
    protected function detachPermissionToRoles($permissionName, $roles)
    {
        $permission = Permission::where("name", "=", $permissionName)->first();
        if ($permission)
        {
            foreach ($roles as $k => $roleName)
            {
                $role = Role::where("name", "=", $roleName)->first();
                if ($role)
                {
                    if ($role->hasPermission($permissionName))
                    {
                        $role->detachPermission($permission);
                    }
                }
            }
        }
    }

    /**
     * Detach the permission to all roles given
     * @param String $permissionName
     * @param String $roleName
     */
    protected function detachPermissionToRole($permissionName, $roleName)
    {
        $permission = Permission::where("name", "=", $permissionName)->first();
        if ($permission)
        {
            $role = Role::where("name", "=", $roleName)->first();
            if ($role)
            {
                if ($role->hasPermission($permissionName))
                {
                    $role->detachPermission($permission);
                }
            }
        }
    }

}
