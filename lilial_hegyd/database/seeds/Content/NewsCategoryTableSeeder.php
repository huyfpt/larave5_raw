<?php

namespace Database\Seeds\Content;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hegyd\News\Models\NewsCategory;
use Illuminate\Support\Facades\DB;

class NewsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        NewsCategory::truncate();
        DB::statement("SET foreign_key_checks=1");
        
        $faker = Faker::create('fr');

        for ($i = 1; $i <= 10; $i ++)
        {
            if ( ! NewsCategory::find($i))
            {
                /*NewsCategory::create([
                    'id'     => $i,
                    'active' => true,
                    'name'   => $faker->text(20),
                    'grip'   => $faker->text(),
                ]);*/
            }
        }

    }
}
