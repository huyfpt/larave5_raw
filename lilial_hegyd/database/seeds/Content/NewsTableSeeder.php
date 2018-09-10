<?php

namespace Database\Seeds\Content;

use Faker\Factory as Faker;
use Hegyd\News\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NewsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement("SET foreign_key_checks=0");
        News::truncate();
        DB::statement("SET foreign_key_checks=1");
        $faker = Faker::create('fr');

        for ($i = 1; $i <= 150; $i ++)
        {
            if ( ! News::find($i))
            {
                $data = [
                    'id'          => $i,
                    'active'      => true,
                    'name'        => $faker->text(20),
                    'slug'        => $faker->slug,
                    'content'     => $faker->text(6000),
                    'category_id' => random_int(1, 10),
                    'author_id'   => 1,
                ];

                // News::create($data);
            }
        }

    }
}
