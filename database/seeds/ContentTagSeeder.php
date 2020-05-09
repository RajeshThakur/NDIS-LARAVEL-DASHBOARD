<?php

use Illuminate\Database\Seeder;
use App\ContentTag;

class ContentTagSeeder extends Seeder
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
                            'name'       => 'Policies',
                            'slug'       => 'policy',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 2,
                            'name'       => 'Audit',
                            'slug'       => 'audit',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 3,
                            'name'       => 'Audit',
                            'slug'       => 'audit',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 4,
                            'name'       => 'Tutorial',
                            'slug'       => 'tutorial',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                    ];

                ContentTag::insert($templates);
    }
}
