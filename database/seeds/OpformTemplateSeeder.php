<?php

use Illuminate\Database\Seeder;
use App\OpformTemplates;
use Illuminate\Support\Facades\DB;

class OpformTemplateSeeder extends Seeder
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
                            'title'      => 'AUTHORITY TO ACT AS AN ADVOCATE',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 2,
                            'title'      => 'Care Plan',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 3,
                            'title'      => 'Client Consent Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 4,
                            'title'      => 'Client Exit / Transition Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 5,
                            'title'      => 'Client Progress Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 6,
                            'title'      => 'Client Referral Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 7,
                            'title'      => 'Support Review Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 8,
                            'title'      => 'Incident Report Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 9,
                            'title'      => 'PARTICIPANT REGISTRATION FORM',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 10,
                            'title'      => 'Risk Assessment',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         => 11,
                            'title'      => 'NDIS Service Agreement',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         =>  12,
                            'title'      => 'Self Assessment Form',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                        [
                            'id'         =>  13,
                            'title'      => 'Engagement Agreement',
                            'status'     => '1',
                            'created_at' => '2019-05-09 13:26:39',
                            'updated_at' => '2019-05-09 13:26:39'
                        ],
                    ];

        OpformTemplates::insert($templates);

        DB::unprepared( file_get_contents( 'storage/databasefile/opforms.sql' ) );
        DB::unprepared( file_get_contents( 'storage/databasefile/opforms_meta.sql' ) );
    }
}
