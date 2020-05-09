<?php

use Illuminate\Database\Seeder;
use App\TaskTag;

class TaskTagTableSeeder extends Seeder
{

    public function run()
    {
        $taskTags = [
            [
                'id'         => '1',
                'name'       => 'Normal',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '2',
                'name'       => 'Booking',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '3',
                'name'       => 'Participant',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '4',
                'name'       => 'SupportWorker',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ]
        ];

        TaskTag::insert($taskTags);
    }
}
