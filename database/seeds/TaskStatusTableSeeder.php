<?php

use App\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusTableSeeder extends Seeder
{
    public function run()
    {
        $taskStatuses = [
            [
                'id'         => '1',
                'name'       => 'Open',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '2',
                'name'       => 'In progress',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '3',
                'name'       => 'On Hold',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ],
            [
                'id'         => '4',
                'name'       => 'Closed',
                'created_at' => '2019-05-09 13:34:11',
                'updated_at' => '2019-05-09 13:34:11',
            ]
        ];

        TaskStatus::insert($taskStatuses);
    }
}
