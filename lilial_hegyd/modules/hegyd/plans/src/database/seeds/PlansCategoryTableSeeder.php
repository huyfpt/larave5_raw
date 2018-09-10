<?php

namespace Hegyd\Plans\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hegyd\Plans\Models\PlansCategory;
use Illuminate\Support\Facades\DB;

class PlansCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        PlansCategory::truncate();
        DB::statement("SET foreign_key_checks=1");
        
        $faker = Faker::create('fr');

        for ($i = 1; $i <= 10; $i ++)
        {
            if ( ! PlansCategory::find($i))
            {
                PlansCategory::create([
                    'id'     => $i,
                    'active' => true,
                    'name'   => $faker->text(20),
                    'grip'   => $faker->text(),
                ]);
            }
        }
    }
}
