<?php namespace Hegyd\Faqs\Database\Seeds;


use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class PermissionNewsletterTableSeeder extends Seeder
{

    public function run()
    {
        $permissions = [
            // ADMIN FAQS
            'admin.newsletters.index'             => [
                'display_name' => 'Consulter la liste des newsletters',
                'category_key' => 'admin.newsletters',
            ],
            'admin.newsletters.create'            => [
                'display_name' => 'Créer un newsletters',
                'category_key' => 'admin.newsletters',
            ],
            'admin.newsletters.edit'              => [
                'display_name' => 'Modifier un newsletters',
                'category_key' => 'admin.newsletters',
            ],
            'admin.newsletters.delete'            => [
                'display_name' => 'Supprimer un newsletters',
                'category_key' => 'admin.newsletters',
            ],

        ];

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