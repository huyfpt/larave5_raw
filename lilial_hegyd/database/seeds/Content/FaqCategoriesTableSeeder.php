<?php
namespace Database\Seeds\Content;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hegyd\Faqs\Models\FaqsCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FaqCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'label' => 'Soin de la continence',
                'introduction' => 'Soin de la continence',
                'parent_id' => 0,
                'status' => 1,
            ],
            [
                'label' => 'Stomathérapie',
                'introduction' => 'Stomathérapie',
                'parent_id' => 0,
                'status' => 1,
            ],
            [
                'label' => 'Soin des plaies',
                'introduction' => 'Soin des plaies',
                'parent_id' => 0,
                'status' => 1,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        FaqsCategory::truncate();

        foreach ($data as $item) {
            if (FaqsCategory::where('label', $item['label'])->first() == null) {
                FaqsCategory::create($item);
            }
            
        }

        Schema::enableForeignKeyConstraints();
    }
}
