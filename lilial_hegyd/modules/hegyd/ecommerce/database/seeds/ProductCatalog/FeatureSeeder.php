<?php namespace Hegyd\eCommerce\Database\Seeds\ProductCatalog;


use Hegyd\eCommerce\Models\ProductCatalog\Feature;
use Hegyd\eCommerce\Models\ProductCatalog\FeatureOption;
use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{

    public function run()
    {
        $datas = [
            [
                'name' => 'Classe du DM',
                'active' => 1,
            ],
            [
                'name' => 'Conditionnement',
                'active' => 1,
            ],
            [
                'name' => 'Raccord support',
                'active' => 1,
            ],
            [
                'name' => 'Embout',
                'active' => 1,
            ],
            [
                'name' => 'Usager',
                'active' => 1,
            ],
            [
                'name' => 'Composition',
                'active' => 1,
            ],
            [
                'name' => 'Longueur bande de colle',
                'active' => 1,
            ],
            [
                'name' => 'Tubulure',
                'active' => 1,
            ],
            [
                'name' => 'Stérile ou non stérile',
                'active' => 1,
            ],
            [
                'name' => 'Contenance',
                'active' => 1,
            ],
            [
                'name' => 'Systeme Couplage',
                'active' => 1,
            ],
            [
                'name' => 'Type de support',
                'active' => 1,
            ],
            [
                'name' => 'Soin et hygiène',
                'active' => 1,
            ],
            [
                'name' => 'Famille de pansement',
                'active' => 1,
            ]
        ];

        foreach ($datas as $data)
        {
            if (Feature::where('name', $data['name'])->first() == null)
            {
                $model = Feature::create($data);

                $this->createFeatureOptions($model->id);
            }
        }

    }

    public function createFeatureOptions($feature_id)
    {
        $datas = [
            [
                'feature_id' => $feature_id,
                'name'       => 'Option 1',
                'value'      => 1
            ],
            [
                'feature_id' => $feature_id,
                'name'       => 'Option 2',
                'value'      => 1
            ],
            [
                'feature_id' => $feature_id,
                'name'       => 'Option 3',
                'value'      => 1
            ],
        ];

        foreach ($datas as $data)
        {
            FeatureOption::create($data);
        }
    }


}