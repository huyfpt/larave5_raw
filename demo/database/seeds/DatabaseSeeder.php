<?php

use Illuminate\Database\Seeder;
use App\Model\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        $datas = [
            [
                'title' => 'section 1',
                'body' => 'text blog 1',
            ],
            [
                'title' => 'section 2',
                'body' => 'text blog 2',
            ],
            [
                'title' => 'section 3',
                'body' => 'text blog 3',
            ],
        ];
    
        foreach ($datas as $data)
        {
                Post::create($data);
        }
    }
}
