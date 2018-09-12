<?php namespace Database\Seeds\Content;

use App\Models\Content\Setting;
use App\Models\Content\SettingCategory;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Do not delete all data in preprod and production
        /*if ( ! in_array(config('app.env'), ['prod', 'production', 'preprod'])) {
            Setting::all()->each(function ($setting) {
                $setting->delete();
            });
        }*/

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
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 2,
                'icon'         => 'fa-phone',
                'type'         => Setting::TYPE_NUMBER,
                'name'         => 'Téléphone',
                'key'          => 'company.phone',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 3,
                'icon'         => 'fa-phone',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Fax',
                'key'          => 'company.fax',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 4,
                'icon'         => 'fa-envelope-o',
                'type'         => Setting::TYPE_TEXTAREA,
                'name'         => 'Adresse',
                'key'          => 'company.address',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 5,
                'icon'         => 'fa-envelope',
                'type'         => Setting::TYPE_TEXTAREA,
                'name'         => 'Adresse (Complément)',
                'key'          => 'company.additional',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 6,
                'icon'         => 'fa-database',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Code postal',
                'key'          => 'company.zip',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 7,
                'icon'         => 'fas fa-flag',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Ville',
                'key'          => 'company.city',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'general',
                'position'     => 8,
                'icon'         => 'fas fa-globe',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Pays',
                'key'          => 'company.country',
                'description'  => '',
                'is_reference' => true
            ],

            // SEO
//            [
//                'category_key' => 'seo',
//                'position'     => 1,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXT,
//                'name'         => 'Meta titre',
//                'key'          => 'seo.meta.title',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 2,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Meta keywords',
//                'key'          => 'seo.meta.keyword',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 3,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Meta description',
//                'key'          => 'seo.meta.description',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 4,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Meta robots',
//                'key'          => 'seo.meta.robot',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 5,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Code Google Analytics',
//                'key'          => 'seo.google.analytics',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 6,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Code Google Verification',
//                'key'          => 'seo.google.verification',
//                'description'  => '',
//            ],
//            [
//                'category_key' => 'seo',
//                'position'     => 7,
//                'icon'         => 'fa-clone',
//                'type'         => Setting::TYPE_TEXTAREA,
//                'name'         => 'Code conversion Formulaire Contact',
//                'key'          => 'seo.conversion.form-contact',
//                'description'  => '',
//            ],

            // Réseaux sociaux
           [
               'category_key' => 'social_network',
               'position'    => 1,
               'icon'        => 'fa-facebook',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Facebook',
               'key'         => 'social.facebook',
               'description' => '',
               'class'       => 'icoFacebook',
               'class_icon'  => 'fas fa-facebook'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 2,
               'icon'        => 'fa-twitter',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Twitter',
               'key'         => 'social.twitter',
               'description' => '',
               'class'       => 'icoTwitter',
               'class_icon'  => 'fas fa-twitter'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 3,
               'icon'        => 'fas fa-linkedin',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Linkedin',
               'key'         => 'social.linkedin',
               'description' => '',
               'class'       => 'icoLinkedin',
               'class_icon'  => 'fas fa-linkedin'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 4,
               'icon'        => 'fa-instagram',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Instagram',
               'key'         => 'social.instagram',
               'description' => '',
               'class'       => 'icoInstagram',
               'class_icon'  => 'fas fa-instagram'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 5,
               'icon'        => 'fa-pinterest-p',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Pinterest',
               'key'         => 'social.pinterest',
               'description' => '',
               'class'       => 'icoPinterest',
               'class_icon'  => 'fas fa-pinterest'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 6,
               'icon'        => 'fa-youtube-square',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Youtube',
               'key'         => 'social.youtube',
               'description' => '',
               'class'       => 'icoYoutube',
               'class_icon'  => 'fas fa-youtube'
           ],
           [
               'category_key' => 'social_network',
               'position'    => 7,
               'icon'        => 'fa-youtube-play',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Dailymotion',
               'key'         => 'social.dailymotion',
               'description' => '',
               'class'       => '',
               'class_icon'  => ''
           ],
           [
               'category_key' => 'social_network',
               'position'    => 8,
               'icon'        => 'fa-google-plus',
               'type'        => Setting::TYPE_TEXT,
               'name'        => 'Google+',
               'key'         => 'social.google-plus',
               'description' => '',
               'class'       => 'icoGoogleplus',
               'class_icon'  => 'fas fa-google-plus'
           ],
//
//            // Emails
//            [
//                'category_key' => 'emails',
//                'position'     => 1,
//                'icon'         => 'fas fa-envelope',
//                'type'         => Setting::TYPE_EMAIL,
//                'name'         => 'Email formulaire de contact',
//                'key'          => 'email.contact-form',
//                'description'  => '',
//            ],

            // Visuels
            [
                'category_key' => 'visuals',
                'category_id'  => 5,
                'position'     => 1,
                'type'         => Setting::TYPE_IMAGE,
                'name'         => 'Logo',
                'key'          => 'visual.logo_frontend',
                'default'      => '/app/img/default/logo.png',
                'is_reference' => true
            ],
            [
                'category_key' => 'visuals',
                'category_id'  => 5,
                'position'     => 2,
                'type'         => Setting::TYPE_IMAGE,
                'name'         => 'Logo BO',
                'key'          => 'visual.logo',
                'default'      => '/app/img/default/logo-squared.png',
                'is_reference' => true
            ],
            [
                'category_key' => 'visuals',
                'category_id'  => 5,
                'position'     => 3,
                'type'         => Setting::TYPE_IMAGE,
                'name'         => 'Logo connexion',
                'key'          => 'visual.logo_large',
                'default'      => '/app/img/default/logo-large.png',
                'is_reference' => true
            ],
            [
                'category_key' => 'visuals',
                'position'     => 4,
                'type'         => Setting::TYPE_IMAGE,
                'name'         => 'Image de fond pour la connexion',
                'key'          => 'visual.auth_background',
                'default'      => '/app/img/default/background-login-register.jpg',
                'is_reference' => true
            ],
            [
                'category_key' => 'visuals',
                'position'     => 5,
                'type'         => Setting::TYPE_IMAGE,
                'name'         => 'Icône du site (favicon)',
                'key'          => 'visual.favicon',
                'default'      => '/app/img/default/favicon.ico',
                'is_reference' => true
            ],

            // Couleurs
            //   COULEUR PRINCIPALE : #ffb245;
            //   BACKGROUND SIDEBAR : #ffb245;
            //   COULEUR DES LIENS SIDEBAR : #ffffff;
            //   BARRE HEADER : #000;
            //   COULEUR DES LIENS HEADER : #ffffff;
            //   BACKGROUND PAGE : #f3f3f3;
            [
                'category_key' => 'colors',
                'position'     => 1,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Couleur principale (menu, liens, boutons, ...)',
                'key'          => 'color.main',
                'default'      => '#ffb245',
                'is_reference' => true
            ],
            [
                'category_key' => 'colors',
                'position'     => 2,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Entête : arrière plan',
                'key'          => 'color.header.background',
                'default'      => '#000000',
                'is_reference' => true
            ],
            [
                'category_key' => 'colors',
                'position'     => 3,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Entête : couleur des liens',
                'key'          => 'color.header.links',
                'default'      => '#ffffff',
                'is_reference' => true
            ],
            [
                'category_key' => 'colors',
                'position'     => 4,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Panneau latéral : arrière plan',
                'key'          => 'color.sidebar.background',
                'default'      => '#ffb245',
                'is_reference' => true
            ],
            [
                'category_key' => 'colors',
                'position'     => 5,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Panneau latéral : Couleur des liens',
                'key'          => 'color.sidebar.links',
                'default'      => '#ffffff',
                'is_reference' => true
            ],
            [
                'category_key' => 'colors',
                'position'     => 6,
                'type'         => Setting::TYPE_COLOR,
                'name'         => 'Couleur d\'arrière plan',
                'key'          => 'color.body.background',
                'default'      => '#f3f3f3',
                'is_reference' => true
            ],

            // Paramétrage des outils statistiques (non administrable)
            [
                'category_key' => 'statistics',
                'position'     => 1,
                'icon'         => 'fa-line-chart',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Google Analytics',
                'key'          => 'google.analytics',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'statistics',
                'position'     => 2,
                'icon'         => 'fa-pencil-square-o',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Paramétrage d’objectifs de conversions',
                'key'          => 'setting.conversion.goals',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'statistics',
                'position'     => 3,
                'icon'         => 'fa-calendar',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Paramétrage d’évènements',
                'key'          => 'setting.event',
                'description'  => '',
                'is_reference' => true
            ],
            [
                'category_key' => 'statistics',
                'position'     => 4,
                'icon'         => 'fa-wrench',
                'type'         => Setting::TYPE_TEXT,
                'name'         => 'Google Webmaster Tools',
                'key'          => 'google.webmaster',
                'description'  => '',
                'is_reference' => true
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

        // Drop if necessary
        Setting::where('key', '=', 'color.menu')->delete();
        Setting::where('key', '=', 'color.header')->delete();

    }
}
