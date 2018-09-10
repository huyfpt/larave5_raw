<?php namespace Database\Seeds\Common;

use App\Models\Common\Shop;
use App\Models\Common\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ShopSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if ( ! in_array(config('app.env'), ['prod', 'production', 'preprod']))
        {

            $faker = Faker::create();

            for ($i = 1; $i < 20; $i ++)
            {
                $shopsData[] = [
                    'id'             => $i,
                    'name'           => 'Agence ' . $i,
                    'department'     => '',
                    'client_code'    => 'AG' . $i,
                    'sector_code'    => null,
                    'sector'         => null,
                    'phone'          => $faker->phoneNumber,
                    'fax'            => $faker->phoneNumber,
                    'email'          => $faker->companyEmail,
                    'director_email' => $faker->email,
                    'ape'            => $faker->numberBetween(100000, 10000000),
                    'siren'          => $faker->numberBetween(100000, 10000000),
                    'siret'          => $faker->numberBetween(100000, 10000000),
                    'code_type'      => null,
                    'code_status'    => null,
                    'sleeping'       => 0,
                    'billing_email'  => null,
                    'created_at_crm' => null,
                    'updated_at_crm' => null,
                    'head_office'    => false,
                    'company_id'     => 1
                ];
            }

            foreach ($shopsData as $shopData)
            {
                $shop = \App\Models\Common\Shop::find($shopData['id']);
                if ( ! $shop)
                {
                    $shop = \App\Models\Common\Shop::create($shopData);
                } else
                {
                    $shop->update($shopData);
                }
            }

        } else
        {
            if (Shop::find(1))
                return;

            Shop::create([
                'id'   => 1,
                'name' => 'Siège',
            ]);
        }

    }
}
