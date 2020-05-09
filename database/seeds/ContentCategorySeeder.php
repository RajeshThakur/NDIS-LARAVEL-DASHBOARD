<?php

use Illuminate\Database\Seeder;
use App\ContentCategory;

class ContentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
                        [
                            'id'         => 1,
                            'name'       => 'policies',
                            'slug'       => 'policies',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 2,
                            'name'       => 'Self Audit',
                            'slug'       => 'audit',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 3,
                            'name'       => 'Past Audit',
                            'slug'       => 'audit',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 4,
                            'name'       => 'Tutorials',
                            'slug'       => 'tutorial',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                    ];

        ContentCategory::insert($templates);
    }
}
