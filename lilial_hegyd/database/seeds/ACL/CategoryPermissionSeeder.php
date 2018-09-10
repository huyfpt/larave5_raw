<?php

namespace Database\Seeds\ACL;

use Hegyd\Permissions\Models\CategoryPermission;
use Illuminate\Database\Seeder;

class CategoryPermissionSeeder extends Seeder
{

    public function run()
    {

        $categories = [

            // EXTRANET CATEGORIES
            'extranet'                       => [
                'name'       => 'Extranet',
                'parent_key' => null,
            ],
            'extranet.access'                => [
                'name'       => 'Accès',
                'parent_key' => 'extranet',
            ],
            'extranet.profile'               => [
                'name'       => 'Mon profil',
                'parent_key' => 'extranet',
            ],
            'extranet.news'                  => [
                'name'       => 'Actualités',
                'parent_key' => 'extranet',
            ],

            // ADMIN CATEGORIES
            'admin'                       => [
                'name'       => 'Interface d\'administration',
                'parent_key' => null,
            ],
            'admin.access'                => [
                'name'       => 'Accès',
                'parent_key' => 'admin',
            ],
            'admin.acl'                   => [
                'name'       => 'Gestion des droits et rôles',
                'parent_key' => 'admin',
            ],
            'admin.eav'                   => [
                'name'       => 'Gestion des attributs',
                'parent_key' => 'admin',
            ],
            'admin.logs'                  => [
                'name'       => 'Gestion des logs',
                'parent_key' => 'admin',
            ],
            'admin.news'                  => [
                'name'       => 'Gestion des actualités',
                'parent_key' => 'admin',
            ],
            'admin.settings'              => [
                'name'       => 'Gestion des paramètres',
                'parent_key' => 'admin',
            ],
            'admin.shops'                 => [
                'name'       => 'Gestion des agences',
                'parent_key' => 'admin',
            ],
            'admin.users'                 => [
                'name'       => 'Gestion des utilisateurs',
                'parent_key' => 'admin',
            ],
            'admin.clients'                 => [
                'name'       => 'Gestion des clients',
                'parent_key' => 'admin',
            ],
            'admin.plans'                 => [
                'name'       => 'Gestion des plans',
                'parent_key' => 'admin',
            ],

            'admin.plans_category'                 => [
                'name'       => 'Gestion des plans catégorie',
                'parent_key' => 'admin',
            ],
            'admin.pages'                 => [
                'name'       => 'Gestion des pages',
                'parent_key' => 'admin',
            ],
            'admin.faqs'                 => [
                'name'       => 'Gestion des faqs',
                'parent_key' => 'admin',
            ],
            'admin.seos'                 => [
                'name'       => 'Gestion des seos',
                'parent_key' => 'admin',
            ],
            'admin.seo_url_redirects'                 => [
                'name'       => 'Gestion des seo_url_redirects',
                'parent_key' => 'admin',
            ],
            'admin.newsletters'                 => [
                'name'       => 'Gestion des newsletters',
                'parent_key' => 'admin',
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


    }
}