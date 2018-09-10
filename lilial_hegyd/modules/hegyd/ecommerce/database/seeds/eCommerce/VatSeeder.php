<?php namespace Hegyd\eCommerce\Database\Seeds;


use Hegyd\eCommerce\Models\eCommerce\Vat;
use Hegyd\Permissions\Models\CategoryPermission;
use Hegyd\Permissions\Models\Permission;
use Hegyd\Permissions\Models\Role;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{

    public function run()
    {
        $datas = [
            [
                'name' => '20%',
                'rate' => 20,
            ],
            [
                'name' => '10%',
                'rate' => 10,
            ],
            [
                'name' => '5,5%',
                'rate' => 5.5,
            ],
            [
                'name' => '2,1%',
                'rate' => 2.1,
            ],
        ];

        foreach ($datas as $data)
        {
            if (Vat::where('rate', $data['rate'])->first() == null)
            {
                Vat::create($data);
            }
        }
    }
}