<?php
namespace Hegyd\Faqs\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(\Hegyd\Faqs\Database\Seeds\FaqCategoriesTableSeeder::class);
    }

}