<?php namespace Hegyd\eCommerce\Database\Seeds;


use App\Models\Content\Setting;
use App\Models\Content\SettingCategory;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [

            // Général
            [
                'category_key' => 'general',
                'position'     => 1,
                'icon'         => 'fa-home',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Nom de la société',
                'key'          => 'company.name',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 2,
                'icon'         => 'fa-phone',
                'type'         => Setting::TYPE_NUMBER,
                'name'         => 'Téléphone',
                'key'          => 'company.phone',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 3,
                'icon'         => 'fa-phone',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Fax',
                'key'          => 'company.fax',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 4,
                'icon'         => 'fa-envelope-o',
                'type'         => Setting::TYPE_TEXTAREA,
                'name'         => 'Adresse',
                'key'          => 'company.address',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 5,
                'icon'         => 'fa-envelope',
                'type'         => Setting::TYPE_TEXTAREA,
                'name'         => 'Adresse (Complément)',
                'key'          => 'company.additional',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 6,
                'icon'         => 'fa-database',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Code postal',
                'key'          => 'company.zip',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 7,
                'icon'         => 'fa fa-flag',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Ville',
                'key'          => 'company.city',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 8,
                'icon'         => 'fa fa-globe',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Pays',
                'key'          => 'company.country',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 9,
                'icon'         => 'fa fa-at',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Email',
                'key'          => 'company.email',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 10,
                'icon'         => 'fa fa-eur',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Capital',
                'key'          => 'company.capital',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 11,
//                'icon'         => 'fa fa-eur',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'SIRET',
                'key'          => 'company.siret',
                'description'  => '',
            ],
            [
                'category_key' => 'general',
                'position'     => 12,
//                'icon'         => 'fa fa-eur',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'APE',
                'key'          => 'company.ape',
                'description'  => '',
            ],
        ];


        foreach ($settings as $settingData)
        {

            // Prepare parent if available
            if (array_key_exists('category_key', $settingData))
            {
                if ($settingData['category_key'] != null)
                {
                    $category = SettingCategory::where('key', '=', $settingData['category_key'])->first();
                    if ($category)
                    {
                        $settingData['category_id'] = $category->id;
                    } else
                    {
                        $this->command->info('Category not found by key : ' . $settingData['category_key']);
                    }
                }
                // Drop category_key entry
                unset($settingData['category_key']);
            }

            $setting = Setting::where('key', '=', $settingData['key'])->first();

            // Create or update setting
            if ($setting)
            {
                // UPDATE
                $setting->update($settingData);
                $this->command->info('Update setting "' . $settingData['key'] . '"');
            } else
            {
                // CREATE
                $setting = Setting::create($settingData);
                $this->command->info('Create setting "' . $settingData['key'] . '"');
            }

        }
    }
}