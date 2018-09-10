<?php namespace Hegyd\eCommerce\Database\Seeds\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BrandSeeder extends Seeder
{

    public function run()
    {
        $datas = [
            [
                'name' => '3M',
                'slug' => str_slug('3M'),
                'logo' => 'logo_3m.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Bard',
                'slug' => str_slug('Bard'),
                'logo' => 'logo_bardcare.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'BBraun',
                'slug' => str_slug('BBraun'),
                'logo' => 'logo_bbraun.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Coloplast',
                'slug' => str_slug('Coloplast'),
                'logo' => 'logo_coloplast.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Convatec',
                'slug' => str_slug('Convatec'),
                'logo' => 'logo_convatec.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Hartmann',
                'slug' => str_slug('Hartmann'),
                'logo' => 'logo_hartmann.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Hollister',
                'slug' => str_slug('Hollister'),
                'logo' => 'logo_hollister.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Lilial',
                'slug' => str_slug('Lilial'),
                'logo' => 'logo_lilial.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Lilial by MICI',
                'slug' => str_slug('Lilial by MICI'),
                'logo' => 'logo_mici_p.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Lohmann & Rauscher',
                'slug' => str_slug('Lohmann & Rauscher'),
                'logo' => 'logo_lr_texte_couleurs.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Ma Mode',
                'slug' => str_slug('Ma Mode'),
                'logo' => 'logo_mamode.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Mölnlycke Healthcare',
                'slug' => str_slug('Mölnlycke Healthcare'),
                'logo' => 'logo_molnlycke.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Peters',
                'slug' => str_slug('Peters'),
                'logo' => 'logo_peters_hd.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Smith & Nephew',
                'slug' => str_slug('Smith & Nephew'),
                'logo' => 'logo_smith_and_nephew.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Teleflex',
                'slug' => str_slug('Teleflex'),
                'logo' => 'logo_teleflex.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'URGO',
                'slug' => str_slug('URGO'),
                'logo' => 'logo_urgo.jpg',
                'position' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Wellspect',
                'slug' => str_slug('Wellspect'),
                'logo' => 'logo_wellspect_healthcare.jpg',
                'position' => 1,
                'active' => 1,
            ],
        ];

        if (Brand::where('logo', $datas[1]['logo'])->first()) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        Brand::truncate();
        foreach ($datas as $data)
        {
            if (Brand::where('name', $data['name'])->first() == null)
            {
                Brand::create($data);
            }
        }
        Schema::enableForeignKeyConstraints();

    }


}