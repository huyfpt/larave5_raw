<?php namespace Database\Seeds\Common;

use App\Models\Common\User;
use App\Models\Common\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $faker = \Faker\Factory::create();
        $civilities = [User::CIVILITY_MISTER, User::CIVILITY_MADAM];
        $roles = [User::ROLE_SUPER, User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_CLIENT];

        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");

        $this->adminAccount();

        /*for($i=2; $i<=100; $i++)
        {
            User::create([
                'id'        => $i,
                'active'    => $faker->boolean(),
                'civility'  => $faker->randomElement($array = $civilities),
                'firstname' => $faker->firstName,
                'lastname'  => $faker->lastName,
                'username'  => $faker->unique->userName,
                'email'     => $faker->freeEmail,
                'password'  => bcrypt('password'),
                'phone'     => $faker->phoneNumber,
                'mobile'    => $faker->tollFreePhoneNumber,
                'role_id'   => $faker->randomElement($array = $roles),
            ]);
        }*/

        $this->createClient();
    }

    public function adminAccount()
    {
        // INITIALIZE HEGYD ACCOUNTS
        $usersData = [
            [
                'id'        => 1,
                'active'    => true,
                'civility'  => User::CIVILITY_MISTER,
                'firstname' => 'Admin',
                'lastname'  => 'Test',
                'username'  => 'admin',
                'email'     => 'admin@admin.com',
                'password'  => bcrypt('123admin'),
                'role_id'   => User::ROLE_SUPER,
            ],
        ];
        // Define user default for user creation
        $userDefault = [];
        foreach ($usersData as $userData)
        {
            $user = \App\Models\Common\User::find($userData['id']);
            if ( ! $user)
            {
                $user = \App\Models\Common\User::create(
                    $userData + $userDefault
                );
            } else
            {
                $user->update($userData);
            }
            $user->shops()->sync([1 => ["role_id" => 1]]);
        }
    }

    public function createClient()
    {
        DB::statement("SET foreign_key_checks=0");
        Client::truncate();
        DB::statement("SET foreign_key_checks=1");
        $faker = \Faker\Factory::create();
        $clients = User::where('role_id', User::ROLE_CLIENT)->pluck('id')->toArray();
        /*for($i=0;$i<count($clients);$i++) {
            Client::create([
                'user_id'       => $faker->unique->randomElement($array = $clients),
                'type'          => $faker->randomElement($array = ['user', 'professional']),
                'club_lilial'   => $faker->boolean(),
                'ambassador'    => $faker->boolean(),
            ]);
        }*/
    }
}
