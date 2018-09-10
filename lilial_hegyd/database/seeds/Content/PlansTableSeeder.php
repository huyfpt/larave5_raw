<?php

namespace Database\Seeds\Content;

use Faker\Factory as Faker;
use Hegyd\Plans\Models\Plans;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Plans::truncate();
        DB::statement("SET foreign_key_checks=1");
        
        $faker = Faker::create('fr');

        for ($i = 1; $i <= 150; $i ++)
        {
            if ( ! Plans::find($i))
            {
                $data = [
                    'id'          => $i,
                    'active'      => true,
                    'title'       => $faker->text(20),
                    'slug'        => $faker->slug,
                    'content'     => $faker->text(6000),
                    'avantage'    => $faker->boolean(),
                    'visibility'  => $faker->boolean(),
                    'url'         => $faker->url,
                    'category_id' => random_int(1, 10),
                ];

                // Plans::create($data);
            }
        }

    }
}
