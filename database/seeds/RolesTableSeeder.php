<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
                    [
                        'id'         => 1,
                        'title'      => 'Admin',
                        'created_at' => '2019-05-09 13:26:39',
                        'updated_at' => '2019-05-09 13:26:39',
                        'deleted_at' => null,
                    ],
                    [
                        'id'         => 2,
                        'title'      => 'Provider',
                        'created_at' => '2019-05-09 13:26:39',
                        'updated_at' => '2019-05-09 13:26:39',
                        'deleted_at' => null,
                    ],
                    [
                        'id'         => 3,
                        'title'      => 'Participant',
                        'created_at' => '2019-05-09 13:26:39',
                        'updated_at' => '2019-05-09 13:26:39',
                        'deleted_at' => null,
                    ],
                    [
                        'id'         => 4,
                        'title'      => 'Support Worker',
                        'created_at' => '2019-05-09 13:26:39',
                        'updated_at' => '2019-05-09 13:26:39',
                        'deleted_at' => null,
                    ],
                    [
                        'id'         => 5,
                        'title'      => 'External Service Provider',
                        'created_at' => '2019-05-09 13:26:39',
                        'updated_at' => '2019-05-09 13:26:39',
                        'deleted_at' => null,
                    ]
                ];

        Role::insert($roles);
    }
}
