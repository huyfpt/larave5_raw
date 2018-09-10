<?php namespace Database\Seeds\Content;

use App\Models\Content\SettingCategory;
use Illuminate\Database\Seeder;

class SettingCategoryTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
               //'id'   => 1,
                'key'  => 'general',
                'name' => 'Général',
            ],
//            [
//                'id'   => 2,
//                'key'  => 'seo',
//                'name' => 'SEO',
//            ],
           [
               //'id'   => 3,
               'key'  => 'social_network',
               'name' => 'Réseaux sociaux',
           ],
//            [
////                'id'   => 4,
//                'key'  => 'emails',
//                'name' => 'Emails',
//            ],
            [
               //'id'   => 5,
                'key'  => 'visuals',
                'name' => 'Visuels',
            ],
            [
               //'id'   => 6,
                'key'  => 'colors',
                'name' => 'Couleurs',
            ],
//            [
////                'id'   => 6,
//                'key'  => 'commissions',
//                'name' => 'Commissions',
//            ],
           
            [
                //'id'    => 7,
                'key'   => 'statistics',
                'name'  => 'Statistiques'
            ]

        ];

        foreach ($categories as $categoryData)
        {
            $category = SettingCategory::where('key', '=', $categoryData['key'])->first();

            if ($category)
            {
                // UPDATE
                $category->update($categoryData);
                $this->command->info('Update category "' . $categoryData['key'] . '"');
            } else
            {
                // CREATE
                $category = SettingCategory::create($categoryData);
                $this->command->info('Create category "' . $categoryData['key'] . '"');
            }

        }

    }
}
