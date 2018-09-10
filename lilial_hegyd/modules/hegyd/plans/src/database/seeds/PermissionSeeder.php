<?php namespace Hegyd\Plans\Database\Seeds;


use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        $categories = [
            // ADMIN PLANS
            'admin.plans'                 => [
                'name'       => 'Gestion des plans',
                'parent_key' => 'admin',
            ],
            // ADMIN PLANS CATEGORY
            'admin.plans_category'                 => [
                'name'       => 'Gestion des plans catégorie',
                'parent_key' => 'admin',
            ],
        ];

        $permissions = [
            // ADMIN PLANS
            'admin.plans.index'             => [
                'display_name' => 'Consulter la liste des plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans.create'            => [
                'display_name' => 'Créer un plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans.edit'              => [
                'display_name' => 'Modifier un plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans.delete'            => [
                'display_name' => 'Supprimer un plans',
                'category_key' => 'admin.plans',
            ],

            // ADMIN PLANS CATEGORY
            'admin.plans_category.index'     => [
                'display_name' => 'Consulter la liste des catégories plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans_category.create'    => [
                'display_name' => 'Créer une catégorie plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans_category.edit'      => [
                'display_name' => 'Modifier une catégorie plans',
                'category_key' => 'admin.plans',
            ],
            'admin.plans_category.delete'    => [
                'display_name' => 'Supprimer une catégorie plans',
                'category_key' => 'admin.plans',
            ],

        ];

        $this->command->info('Seeding : Database\Seeds\ACL\CategoryPermissionsSeeder');

        foreach ($categories as $category_key => $category_data)
        {

            // Prepare parent if available
            if (array_key_exists('parent_key', $category_data))
            {

                if ($category_data['parent_key'] != null)
                {

                    $parent = CategoryPermission::where('key', '=', $category_data['parent_key'])->first();

                    if ($parent)
                    {
                        $category_data['parent_id'] = $parent->id;
                    } else
                    {
                        $this->command->info('Parent not found by key : ' . $category_data['parent_key']);
                    }

                }

                // Drop parent key entry
                unset($category_data['parent_key']);

            }

            $category = CategoryPermission::where('key', '=', $category_key)->first();

            if ($category)
            {

                // UPDATE
                $category->update($category_data);
                $this->command->info('Update category "' . $category_key . '"');

            } else
            {

                // CREATE
                $category_data['key'] = $category_key;
                $category = CategoryPermission::create($category_data);
                $this->command->info('Create category "' . $category_key . '"');
            }
        }

        $this->command->info('Seeding : Database\Seeds\ACL\PermissionSeeder');

        foreach ($permissions as $permission_key => $permission_data)
        {

            // Prepare category if available
            if (array_key_exists('category_key', $permission_data))
            {

                if ($permission_data['category_key'] != null)
                {

                    $category = CategoryPermission::where('key', '=', $permission_data['category_key'])->first();

                    if ($category)
                    {
                        $permission_data['category_id'] = $category->id;
                    } else
                    {
                        $this->command->error('Category not found by key : ' . $permission_data['category_key']);
                    }

                }

                // Drop useless category key entry
                unset($permission_data['category_key']);

            }

            $permission = Permission::whereName($permission_key)->first();

            if ($permission)
            {

                // UPDATE
                $permission->update($permission_data);
                $this->command->info('Update permission "' . $permission_key . '"');

            } else
            {

                // CREATE
                $permission_data['name'] = $permission_key;
                $permission = Permission::create($permission_data);
                $this->command->info('Create permission "' . $permission_key . '"');

            }

            $this->attachPermissionToRole($permission->name, 'admin');
            $this->attachPermissionToRole($permission->name, 'super_admin');

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
}