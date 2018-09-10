<?php namespace Hegyd\eCommerce\Database\Seeds\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{

    public function run()
    {

        $data = [
            [
                'name' => 'Urologie',
                'slug' => str_slug('Urologie'),
                'parent_id' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Stomathérapie',
                'slug' => str_slug('Stomathérapie'),
                'parent_id' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Cicatrisation',
                'slug' => str_slug('Cicatrisation'),
                'parent_id' => 0,
                'active' => 1,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        Category::truncate();

        foreach ($data as $item) {
            if (Category::where('name', $item['name'])->first() == null)
            {
                Category::create($item);
            }
            
        }

        Schema::enableForeignKeyConstraints();

        //$this->_createCategory(0, 1);

    }

    public function _createCategory($parent_id, $level)
    {
        for($i=1; $i <= 5; $i++)
        {

            $data['name'] = 'Category '. $level.'.'.$i;
            $data['active'] = 1;
            $data['parent_id'] = $parent_id;

            if (Category::where('name', $data['name'])->first() == null)
            {
                $model = Category::create($data);

                if ($level <= 2) {
                    $this->_createCategory($model->id, $level+1);
                }
            }
        }
    }


}