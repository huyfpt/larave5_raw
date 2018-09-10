<?php

namespace Database\Seeds\ACL;

//use App\Models\ACL\Permission;
//use App\Models\ACL\Role;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Hegyd\Permissions\Models\CategoryPermission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {

        $permissions = [

            ////////////////////////////////////////////////////////////////////
            // EXTRANET
            ////////////////////////////////////////////////////////////////////

            // EXTRANET - ACCESS
            'extranet.profile.show'         => [
                'display_name' => 'Consulter "Mon profil"',
                'category_key' => 'extranet.profile',
            ],
            'extranet.profile.edit'         => [
                'display_name' => 'Editer "Mon profil"',
                'category_key' => 'extranet.profile',
            ],


            // EXTRANET - NEWS
            'extranet.news.index'           => [
                'display_name' => 'Consulter les actualités',
                'category_key' => 'extranet.news',
            ],
            'extranet.news.comments.create' => [
                'display_name' => 'Ajouter un commentaire',
                'category_key' => 'extranet.news',
            ],

            'extranet.news.comments.edit' => [
                'display_name' => 'Editer un commentaire',
                'category_key' => 'extranet.news',
            ],

            'extranet.news.comments.delete' => [
                'display_name' => 'Supprimer un commentaire',
                'category_key' => 'extranet.news',
            ],

            'extranet.news.comments.report' => [
                'display_name' => 'Signaler un commentaire',
                'category_key' => 'extranet.news',
            ],


            ////////////////////////////////////////////////////////////////////
            // ADMIN
            ////////////////////////////////////////////////////////////////////

            // ADMIN - ACCESS
            'admin.access'                  => [
                'display_name' => 'Accéder au menu "Administration"',
                'category_key' => 'admin.access',
            ],

            // ADMIN - LOGS
            'admin.logs.index'              => [
                'display_name' => 'Consulter les logs',
                'category_key' => 'admin.logs',
            ],
            'admin.logs.export'             => [
                'display_name' => 'Exporter les logs',
                'category_key' => 'admin.logs',
            ],

            // ADMIN - USERS
            'admin.users.index'             => [
                'display_name' => 'Consulter la liste des utilisateurs',
                'category_key' => 'admin.users',
            ],
            'admin.users.create'            => [
                'display_name' => 'Créer un utilisateur',
                'category_key' => 'admin.users',
            ],
            'admin.users.edit'              => [
                'display_name' => 'Modifier un utilisateur',
                'category_key' => 'admin.users',
            ],
            'admin.users.delete'            => [
                'display_name' => 'Supprimer un utilisateur',
                'category_key' => 'admin.users',
            ],
            'admin.users.export'            => [
                'display_name' => 'Exporter les utilisateurs',
                'category_key' => 'admin.users',
            ],

            // ADMIN - AGENCES
            'admin.shops.index'             => [
                'display_name' => 'Consulter la liste des agences',
                'category_key' => 'admin.shops',
            ],
            'admin.shops.create'            => [
                'display_name' => 'Créer une agence',
                'category_key' => 'admin.shops',
            ],
            'admin.shops.edit'              => [
                'display_name' => 'Modifier une agence',
                'category_key' => 'admin.shops',
            ],
            'admin.shops.delete'            => [
                'display_name' => 'Supprimer une agence',
                'category_key' => 'admin.shops',
            ],
            'admin.shops.export'            => [
                'display_name' => 'Exporter les agences',
                'category_key' => 'admin.shops',
            ],


            // ADMIN - SETTINGS
            'admin.settings.index'          => [
                'display_name' => 'Consulter les paramètres',
                'category_key' => 'admin.settings',
            ],
            'admin.settings.edit'           => [
                'display_name' => 'Modifier les paramètres',
                'category_key' => 'admin.settings',
            ],

            /* BEGIN EAV/ATTRIBUTES */
            'admin.eav.index'               => [
                'display_name' => 'Consulter les attributs',
                'category_key' => 'admin.eav',
            ],
            'admin.eav.values.create'       => [
                'display_name' => 'Ajouter des valeurs d\'attributs',
                'category_key' => 'admin.eav',
            ],
            'admin.eav.values.edit'         => [
                'display_name' => 'Modifier les valeurs d\'attributs',
                'category_key' => 'admin.eav',
            ],
            'admin.eav.values.delete'       => [
                'display_name' => 'Supprimer des valeurs d\'attributs',
                'category_key' => 'admin.eav',
            ],
            'admin.eav.values.move'         => [
                'display_name' => 'Déplacer les valeurs d\'attributs',
                'category_key' => 'admin.eav',
            ],
            /* END EAV/ATTRIBUTES */

            // ADMIN - ACL
            'admin.acl.index'               => [
                'display_name' => 'Consulter les droits & rôles',
                'category_key' => 'admin.acl',
            ],
            'admin.acl.edit'                => [
                'display_name' => 'Modifier les droits & rôles',
                'category_key' => 'admin.acl',
            ],


            /* NEWS BEGIN */
            'admin.news.index'              => [
                'display_name' => 'Consulter la liste des actualités',
                'category_key' => 'admin.news',
            ],
            'admin.news.create'             => [
                'display_name' => 'Créer une actualité',
                'category_key' => 'admin.news',
            ],
            'admin.news.edit'               => [
                'display_name' => 'Modifier une actualité',
                'category_key' => 'admin.news',
            ],
            'admin.news.delete'             => [
                'display_name' => 'Supprimer une actualité',
                'category_key' => 'admin.news',
            ],
            /* NEWS END */


            /* NEWS CATEGORY BEGIN */
            'admin.news.category.index'     => [
                'display_name' => 'Consulter la liste des catégories d\'actualités',
                'category_key' => 'admin.news',
            ],
            'admin.news.category.create'    => [
                'display_name' => 'Créer une catégorie d\'actualité',
                'category_key' => 'admin.news',
            ],
            'admin.news.category.edit'      => [
                'display_name' => 'Modifier une catégorie d\'actualité',
                'category_key' => 'admin.news',
            ],
            'admin.news.category.delete'    => [
                'display_name' => 'Supprimer une catégorie d\'actualité',
                'category_key' => 'admin.news',
            ],
            /* NEWS CATEGORY END */

            /* NEWS REPORT COMMENT BEGIN */
            'admin.news.report_comment.index'  => [
                'display_name' => 'Consulter la liste des signalements',
                'category_key' => 'admin.news',
            ],
            'admin.news.report_comment.show' => [
                'display_name' => 'Voir un signalement',
                'category_key' => 'admin.news',
            ],
            'admin.news.report_comment.edit' => [
                'display_name' => 'Editer un signalement',
                'category_key' => 'admin.news',
            ],
            'admin.news.report_comment.delete' => [
                'display_name' => 'Supprimer commentaire',
                'category_key' => 'admin.news',
            ],
            /* NEWS REPORT COMMENT END */

            // ADMIN - CLIENTS
            'admin.clients.index'             => [
                'display_name' => 'Consulter la liste des clients',
                'category_key' => 'admin.clients',
            ],
            'admin.clients.create'            => [
                'display_name' => 'Créer un clients',
                'category_key' => 'admin.clients',
            ],
            'admin.clients.edit'              => [
                'display_name' => 'Modifier un clients',
                'category_key' => 'admin.clients',
            ],
            'admin.clients.delete'            => [
                'display_name' => 'Supprimer un clients',
                'category_key' => 'admin.clients',
            ],
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


            // ADMIN - PAGES
            'admin.pages.index'             => [
                'display_name' => 'Consulter la liste des pages',
                'category_key' => 'admin.pages',
            ],
            'admin.pages.create'            => [
                'display_name' => 'Créer un pages',
                'category_key' => 'admin.pages',
            ],
            'admin.pages.edit'              => [
                'display_name' => 'Modifier un pages',
                'category_key' => 'admin.pages',
            ],
            'admin.pages.delete'            => [
                'display_name' => 'Supprimer un pages',
                'category_key' => 'admin.pages',
            ],

            // ADMIN - SEO
            'admin.seos.index'             => [
                'display_name' => 'Consulter la liste des seos',
                'category_key' => 'admin.seos',
            ],
            'admin.seos.create'            => [
                'display_name' => 'Créer un seos',
                'category_key' => 'admin.seos',
            ],
            'admin.seos.edit'              => [
                'display_name' => 'Modifier un seos',
                'category_key' => 'admin.seos',
            ],
            'admin.seos.delete'            => [
                'display_name' => 'Supprimer un seos',
                'category_key' => 'admin.seos',
            ],
            // ADMIN - SEO_URL_REDIRECT
            'admin.seo_url_redirects.index'             => [
                'display_name' => 'Consulter la liste des seo_url_redirects',
                'category_key' => 'admin.seo_url_redirects',
            ],
            'admin.seo_url_redirects.create'            => [
                'display_name' => 'Créer un seo_url_redirects',
                'category_key' => 'admin.seo_url_redirects',
            ],
            'admin.seo_url_redirects.edit'              => [
                'display_name' => 'Modifier un seo_url_redirects',
                'category_key' => 'admin.seo_url_redirects',
            ],
            'admin.seo_url_redirects.delete'            => [
                'display_name' => 'Supprimer un seo_url_redirects',
                'category_key' => 'admin.seo_url_redirects',
            ],

            // ADMIN - FAQS
            'admin.faqs.index'             => [
                'display_name' => 'Consulter la liste des faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs.create'            => [
                'display_name' => 'Créer un faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs.edit'              => [
                'display_name' => 'Modifier un faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs.delete'            => [
                'display_name' => 'Supprimer un faqs',
                'category_key' => 'admin.faqs',
            ],

            // ADMIN NEWSLETTER
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

            /* FAQS CATEGORY BEGIN */
            'admin.faqs_category.index'     => [
                'display_name' => 'Consulter la liste des catégories faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs_category.create'    => [
                'display_name' => 'Créer une catégorie faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs_category.edit'      => [
                'display_name' => 'Modifier une catégorie faqs',
                'category_key' => 'admin.faqs',
            ],
            'admin.faqs_category.delete'    => [
                'display_name' => 'Supprimer une catégorie faqs',
                'category_key' => 'admin.faqs',
            ]

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