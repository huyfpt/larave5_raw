<?php

namespace Hegyd\Faqs\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hegyd\Faqs\Models\Newsletter;
use Illuminate\Support\Facades\DB;

class NewsletterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Newsletter::truncate();
        DB::statement("SET foreign_key_checks=1");
        
        $faker = Faker::create('fr');

        for ($i = 1; $i <= 150; $i ++)
        {
            if ( ! Newsletter::find($i))
            {
                $data = [
                    'id'          => $i,
                    'active'      => true,
                    'first_name'  => $faker->firstName('female'),
                    'last_name'   => $faker->lastName(),
                    'email'       => $faker->companyEmail()
                ];

                Newsletter::create($data);
            }
        }
    }
}
