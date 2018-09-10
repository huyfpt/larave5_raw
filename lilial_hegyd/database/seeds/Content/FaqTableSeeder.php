<?php
namespace Database\Seeds\Content;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hegyd\Faqs\Models\FaqsCategory;
use Hegyd\Faqs\Models\Faqs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Support\Facades\Storage;
class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr');
        $source_path = base_path() .'/public/vendor/hegyd/faqs/img/default_news.jpg';
        $des_path = storage_path() . '/app/public/faqs/default_news.jpg';

        \File::copy($source_path, $des_path);
        Schema::disableForeignKeyConstraints();
        Faqs::truncate();
        $categories = FaqsCategory::all();
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                for ($i=1; $i < 100; $i++) { 
                    $title = $faker->sentence($nbWords = 6, $variableNbWords = true);
                    $slug  = str_slug($title);
                    Faqs::create([
                        'status'           => 1,
                        'title'            => $title,
                        'slug'             => $slug,
                        'content'          => $faker->text($maxNbChars = 200),
                        'meta_title'       => 'test',
                        'meta_description' => 'test2',
                        'meta_keyword'     => 'meta keywords',
                        'start_at'         => now(),
                        'end_at'           => date('Y-m-d H:i:s', strtotime("+7 day")),
                        'category_id'      => $category->id,
                        'author_id'        => 1
                    ]);
                }
            }
        }
        // add image
        $this->createUploadImg($des_path);
        Schema::enableForeignKeyConstraints();
    }

    protected function createUploadImg($path)
    {
        for ($i=1; $i < 298; $i++) { 
            Upload::create([
                'visibility' => 2,
                'type' => 10,
                'size' => null,
                'mime_type' => 'image/jpeg',
                'extension' => 'jpeg',
                'filename' => 'default_news.jpg',
                'path' => $path,
                'media' => null,
                'name' => null,
                'description' => null,
                'uploadable_id' => $i,
                'uploadable_type' => 'Hegyd\Faqs\Models\Faqs',
                'creator_id' => 1,
                'updator_id' => 1,
                'position' => null,
            ]);
        }
    }
}
