<?php namespace Hegyd\eCommerce\Database\Seeds;


use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{

    public function run()
    {
        $categories = [
            // ADMIN CATEGORIES
            'admin'            => [
                'name'       => 'Interface d\'administration',
                'parent_key' => null,
            ],
            'admin.products'   => [
                'name'       => 'Gestion des produits',
                'parent_key' => 'admin',
            ],
            'admin.categories' => [
                'name'       => 'Gestion des catégories',
                'parent_key' => 'admin',
            ],
            'admin.orders'     => [
                'name'       => 'Gestion des commandes',
                'parent_key' => 'admin',
            ],

            'extranet'          => [
                'name'       => 'Extranet',
                'parent_key' => null,
            ],
            'extranet.ecommerce' => [
                'name'       => 'eCommerce',
                'parent_key' => 'extranet',
            ],
        ];

        $permissions = [
            /* BACKEND PRODUCT BEGIN */
            'admin.products.index'     => [
                'display_name' => 'Consulter les produits',
                'category_key' => 'admin.products',
            ],
            'admin.products.create'    => [
                'display_name' => 'Créer un produit',
                'category_key' => 'admin.products',
            ],
            'admin.products.edit'      => [
                'display_name' => 'Éditer un produit',
                'category_key' => 'admin.products',
            ],
            'admin.products.delete'    => [
                'display_name' => 'Supprimer un produit',
                'category_key' => 'admin.products',
            ],
            /* BACKEND PRODUCT END */

            /* BACKEND CATEGORY BEGIN */
            'admin.categories.index'   => [
                'display_name' => 'Consulter les catégories',
                'category_key' => 'admin.categories',
            ],
            'admin.categories.create'  => [
                'display_name' => 'Créer une catégorie',
                'category_key' => 'admin.categories',
            ],
            'admin.categories.edit'    => [
                'display_name' => 'Éditer une catégorie',
                'category_key' => 'admin.categories',
            ],
            'admin.categories.delete'  => [
                'display_name' => 'Supprimer une catégorie',
                'category_key' => 'admin.categories',
            ],
            /* BACKEND CATEGORY END */
            /* BACKEND ORDER BEGIN */
            'admin.orders.index'       => [
                'display_name' => 'Consulter les commandes',
                'category_key' => 'admin.orders',
            ],
            'admin.orders.edit'        => [
                'display_name' => 'Éditer une commande',
                'category_key' => 'admin.orders',
            ],
            'admin.orders.delete'      => [
                'display_name' => 'Supprimer une commande',
                'category_key' => 'admin.orders',
            ],
            'admin.orders.archived'    => [
                'display_name' => 'Consulter les commandes archivées',
                'category_key' => 'admin.orders',
            ],
            /* BACKEND ORDER END */

            /* FRONTEND PRODUCT BEGIN */
            'extranet.ecommerce.index'  => [
                'display_name' => 'Accéder au module eCommerce',
                'category_key' => 'extranet.ecommerce',
            ],
            /* FRONTEND PRODUCT END */

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