<?php

namespace Database\Seeds\ACL;

use App\Models\ACL\Permission;
use Illuminate\Database\Seeder;
use Hegyd\Permissions\Models\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {

        $roles = [
            'super_admin'     => [
                'display_name' => 'Super Administrateur',
                'description'  => '',
            ],
            'admin'     => [
                'display_name' => 'Administrateur',
                'description'  => '',
            ],
            'user'   => [
                'display_name' => 'Utilisateur',
                'description'  => '',
            ],
            'client'  => [
                'display_name' => 'Client',
                'description'  => '',
            ]
        ];

        $this->command->info('Seeding : Database\Seeds\ACL\RoleSeeder');

        foreach ($roles as $role_key => $role_data)
        {

            $role = Role::whereName($role_key)->first();

            if ($role)
            {

                // UPDATE
                $role->update($role_data);
                $this->command->info('Update role "' . $role_key . '"');

            } else
            {

                // CREATE
                $role_data['name'] = $role_key;
                $role = Role::create($role_data);
                $this->command->info('Create role "' . $role_key . '"');

            }

        }

    }
}