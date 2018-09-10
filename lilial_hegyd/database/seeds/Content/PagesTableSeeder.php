<?php namespace Database\Seeds\Content;


use Hegyd\Pages\Models\Pages;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesTableSeeder extends Seeder
{

    public function run()
    {

        // Schema::disableForeignKeyConstraints();
        Pages::truncate();
        // Schema::enableForeignKeyConstraints();
        // return;

            $datas = [
                [
                    'title'        => 'history',
                    'content'   => '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</span><br></p>',
                    'description' => 'history page',
                    'slug' => 'history',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Our team',
                    'content'   => '<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. SED ORNARE VITAE NUNC NON IACULIS. NAM DICTUM VITAE MAGNA AT IMPERDIET. CRAS TINCIDUNT PURUS IN NUNC LAOREET AUCTOR. CURABITUR AC COMMODO SEM, QUIS TEMPUS SEM. INTEGER LIGULA DOLOR, LUCTUS ET BIBENDUM EU, IACULIS EU DOLOR. ALIQUAM AUCTOR PURUS IPSUM, QUIS CONSECTETUR EST TINCIDUNT AT. PROIN DIGNISSIM COMMODO ARCU VITAE CONSECTETUR.<br></p>',
                    'description' => 'Our team page',
                    'slug' => 'our-team',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Lilial is committed',
                    'content'   => '<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. SED ORNARE VITAE NUNC NON IACULIS. NAM DICTUM VITAE MAGNA AT IMPERDIET. CRAS TINCIDUNT PURUS IN NUNC LAOREET AUCTOR. CURABITUR AC COMMODO SEM, QUIS TEMPUS SEM. INTEGER LIGULA DOLOR, LUCTUS ET BIBENDUM EU, IACULIS EU DOLOR. ALIQUAM AUCTOR PURUS IPSUM, QUIS CONSECTETUR EST TINCIDUNT AT. PROIN DIGNISSIM COMMODO ARCU VITAE CONSECTETUR.<br></p>',
                    'description' => 'Lilial is committed page',
                    'slug' => 'lilial-is-committed',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Coloplast',
                    'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.<br></p>',
                    'description' => 'Coloplast page',
                    'slug' => 'coloplast',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Qui sommes-nous',
                    'content'   => '<p>about pages</p>',
                    'description' => 'view page about',
                    'slug' => 'qui-sommes-nous',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Mentions légales',
                    'content'   => '<p>mention page</p>',
                    'description' => 'mention view page',
                    'slug' => 'mentions-legales',
                    'status'      => 1,
                ],
                [
                    'title'        => 'Recrutement',
                    'content'   => '<p>recrutement pages</p>',
                    'description' => 'view recrutement page',
                    'slug' => 'recrutement',
                    'status'      => 1,
                ],
                
            ];


            foreach ($datas as $data)
            {
                if (Pages::where('slug', $data['slug'])->first() == null) {
                    Pages::create($data);
                }
            }
    }
}