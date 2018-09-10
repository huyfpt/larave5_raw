<?php namespace Hegyd\eCommerce\Database\Seeds\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Models\ProductCatalog\ProductFaq;
use Hegyd\eCommerce\Models\ProductCatalog\ProductRelated;
use Hegyd\eCommerce\Models\ProductCatalog\ProductAttribute;
use Hegyd\eCommerce\Models\ProductCatalog\Attribute;
use Hegyd\eCommerce\Models\ProductCatalog\AttributeOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        ProductRelated::truncate();
        ProductFaq::truncate();
        ProductAttribute::truncate();
        Schema::enableForeignKeyConstraints();
        return;

        for($i=0; $i < 10; $i++)
        {
            $data = [
                    'name'        => 'Product '. $i,
                    'reference'   => 'DSFSDF' . $i,
                    'grip'        => 'test',
                    'description' => 'test',
                    'category_id' => 1,
                    'brand_id'    => 1,
                    'active'      => 1,
            ];


            if (Product::where('name', $data['name'])->first() == null) {
                $model = Product::create($data);
                
                //$this->createProductAttribute($model->id);
            }

        }

        $all = Product::select('id')->get()->toArray();

        if (empty($all)) {
            return false;
        }

        foreach ($all as $item) {
            $this->createProductRelated($item['id']);
        }

    }

    public function createProductRelated($product_id, $limit = 5)
    {
        $related = Product::select('id')->where('id', '!=', $product_id)->get();
        $related->random(5);
        $data = $related->toArray();

        $i = 0;
        foreach ($data as $item)
        {
            $dataRelated['product_id'] = $product_id;
            $dataRelated['related_id'] = $item['id'];

            ProductRelated::firstOrCreate($dataRelated);

            if ($i++ > $limit) {
                return;
            }
        }
    }

    public function createProductAttribute($product_id)
    {
        $attributes = Attribute::with('option')->where('active', 1)->get()->toArray();

        foreach ($attributes as $data)
        {
            $options = !empty($data['option']) ? $data['option'] : [];

            if (!empty($options)) {
                $option = $options[array_rand($options)];
                $dataProductAttribute['product_id'] = $product_id;
                $dataProductAttribute['option_id'] = $option['id'];

                ProductAttribute::firstOrCreate($dataProductAttribute);
            }
        }
    }


}