<?php namespace Hegyd\eCommerce\Database\Seeds;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(\Hegyd\eCommerce\Database\Seeds\ProductCatalog\AttributeSeeder::class);
        $this->call(\Hegyd\eCommerce\Database\Seeds\ProductCatalog\FeatureSeeder::class);
        $this->call(\Hegyd\eCommerce\Database\Seeds\ProductCatalog\CategorySeeder::class);
        $this->call(\Hegyd\eCommerce\Database\Seeds\ProductCatalog\BrandSeeder::class);
        $this->call(\Hegyd\eCommerce\Database\Seeds\ProductCatalog\ProductSeeder::class);
    }

}