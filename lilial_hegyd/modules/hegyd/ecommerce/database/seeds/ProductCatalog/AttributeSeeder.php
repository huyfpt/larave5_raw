<?php namespace Hegyd\eCommerce\Database\Seeds\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Attribute;
use Hegyd\eCommerce\Models\ProductCatalog\AttributeOption;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{

    public function run()
    {
        $datas = [
            [
                'name' => 'Atribute 1',
                'active' => 1,
            ],
            [
                'name' => 'Atribute 2',
                'active' => 1,
            ],
            [
                'name' => 'Atribute 3',
                'active' => 1,
            ],
        ];

        foreach ($datas as $data)
        {
            if (Attribute::where('name', $data['name'])->first() == null)
            {
                $model = Attribute::create($data);

                $this->createAttributeOptions($model->id);
            }
        }

    }

    public function createAttributeOptions($attribute_id)
    {
        $datas = [
            [
                'attribute_id' => $attribute_id,
                'name' => 'option 1',
            ],
            [
                'attribute_id' => $attribute_id,
                'name' => 'option 2',
            ],
            [
                'attribute_id' => $attribute_id,
                'name' => 'option 3',
            ],
            [
                'attribute_id' => $attribute_id,
                'name' => 'option 4',
            ],
        ];

        foreach ($datas as $data)
        {
            if (AttributeOption::where('name', $data['name'])
                             ->where('attribute_id', $data['attribute_id'])
                             ->first() == null)
            {
                AttributeOption::create($data);
            }
        }
    }


}