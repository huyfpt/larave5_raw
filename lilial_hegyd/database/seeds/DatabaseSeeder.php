<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $env = app()->environment();

        if ($env == 'local')
        {
            $env = 'dev';
        }

        if (method_exists($this, $env))
        {
            $this->{$env}();
        } else
        {
            $this->command->error("Fonction $env() introuvable");
        }
    }

    public function dev()
    {

        $this->call(\Database\Seeds\ACL\RoleSeeder::class);
        $this->call(\Database\Seeds\ACL\CategoryPermissionSeeder::class);
        $this->call(\Database\Seeds\ACL\PermissionSeeder::class);

        $this->call(\Database\Seeds\Common\CompanySeeder::class);
        $this->call(\Database\Seeds\Common\ShopSeeder::class);
        $this->call(\Database\Seeds\Common\UserTableSeeder::class);

        $this->call(\Database\Seeds\Content\SettingCategoryTableSeeder::class);
        $this->call(\Database\Seeds\Content\SettingTableSeeder::class);

        // Load Entity Attributes and all other data
        $this->call(\Database\Seeds\EAV\EntitiesAttributesSeeder::class);

        $this->call(\Database\Seeds\Common\CountrySeeder::class);
        $this->call(\Database\Seeds\Common\CitySeeder::class);

        $this->call(\Database\Seeds\Content\NewsCategoryTableSeeder::class);
        $this->call(\Database\Seeds\Content\NewsTableSeeder::class);

        $this->call(\Database\Seeds\Content\PlansCategoryTableSeeder::class);
        $this->call(\Database\Seeds\Content\PlansTableSeeder::class);
        $this->call(\Database\Seeds\Content\PagesTableSeeder::class);

        $this->call(\Database\Seeds\Content\NewsletterTableSeeder::class);

        $this->call(\Hegyd\eCommerce\Database\Seeds\DatabaseSeeder::class);
        $this->call(\Database\Seeds\Content\FaqCategoriesTableSeeder::class);
        $this->call(\Database\Seeds\Content\FaqTableSeeder::class);
    }

    public function preprod()
    {

    }

    public function prod()
    {

    }

    public function recette()
    {
    }
}
