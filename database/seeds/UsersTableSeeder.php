<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UsersToProviders;
use App\Provider;
use App\Participant;
use App\SupportWorker;
use App\ServiceProvider;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
                    [
                        'id'             => 1,
                        'first_name'     => 'Admin',
                        'last_name'      => 'User',
                        'email'          => 'deepak@dmarkweb.com',
                        'password'       => '$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',
                        'remember_token' => null,
                        'active'         => 1,
                        'created_at'     => '2019-05-09 13:35:50',
                        'updated_at'     => '2019-05-09 13:35:50',
                        'deleted_at'     => null,
                    ],
                    [
                        'id'             => 2,
                        'first_name'     => 'Sam',
                        'last_name'      => 'Provider',
                        'email'          => 'provider@dmarkweb.com',
                        'password'       => '$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',
                        'remember_token' => null,
                        'active'         => 1,
                        'created_at'     => '2019-05-09 13:35:50',
                        'updated_at'     => '2019-05-09 13:35:50',
                        'deleted_at'     => null,
                    ],
                    [
                        'id'             => 3,
                        'first_name'     => 'Jill',
                        'last_name'      => 'Participant',
                        'email'          => 'participant@dmarkweb.com',
                        'password'       => '$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',
                        'remember_token' => null,
                        'active'         => 1,
                        'created_at'     => '2019-05-09 13:35:50',
                        'updated_at'     => '2019-05-09 13:35:50',
                        'deleted_at'     => null,
                    ],
                    [
                        'id'             => 4,
                        'first_name'     => 'Summy',
                        'last_name'      => 'Worker',
                        'email'          => 'supportworker@dmarkweb.com',
                        'password'       => '$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',
                        'remember_token' => null,
                        'active'         => 1,
                        'created_at'     => '2019-05-09 13:35:50',
                        'updated_at'     => '2019-05-09 13:35:50',
                        'deleted_at'     => null,
                    ],
                    [
                        'id'             => 5,
                        'first_name'     => 'David',
                        'last_name'      => 'Ext Worker',
                        'email'          => 'extprovider@ndis.org',
                        'password'       => '$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',
                        'remember_token' => null,
                        'active'         => 1,
                        'created_at'     => '2019-05-09 13:35:50',
                        'updated_at'     => '2019-05-09 13:35:50',
                        'deleted_at'     => null,
                    ]
        ];

        User::insert($users);


        //-----------------------------------------------------------------
        // User to Provider
        $userProviders = [
            [
                'user_id'        => 3,
                'provider_id'    => 2,
                'deleted_at'     => null,
                
            ],
            [
                'user_id'        => 4,
                'provider_id'    => 2,
                'deleted_at'     => null,
            ],
            [
                'user_id'        => 5,
                'provider_id'    => 2,
                'deleted_at'     => null,
            ]
        ];

        UsersToProviders::insert($userProviders);


        //-----------------------------------------------------------------
        // Providers Seeder

        $provider = [
            [
                'user_id'               => 2,
                'organisation_id'       => 123,
                'ra_number'             => 123,
                'renewal_date'          => '2021-12-31',
                'ndis_cert'             => '',
                'is_onboarding_complete'  => 1,
                'created_at'     => '2019-05-09 13:35:50',
                'updated_at'     => '2019-05-09 13:35:50',
                'deleted_at'     => null,
              
            ]
        ];
        Provider::insert($provider);


        //-----------------------------------------------------------------
        //Participants
        $participants = [
            [
                'user_id'               => 3,
                'address'               => '77 Storey St, Maroubra NSW 2035, Australia',
                'lat'                   => '-33.9366382',
                'lng'                   => '151.2343795',
                'start_date_ndis'       => '2018-12-09 13:35:50',
                'end_date_ndis'         => '2020-05-09 13:35:50',
                'ndis_number'           => '01_011_0117_3_1',
                'participant_goals'     => '',
                'special_requirements'  => '',
                'budget_funding'        => 10000,
                'funds_balance'         => 10000,
                'have_gps_phone'        => 1,
                'using_guardian'        => 0,
                'guardian_id'           => 0,
                'agreement_signed'      => 1,
                'onboarding_step'       => 1,
                'is_onboarding_complete' => 1,
                'created_at'     => '2019-05-09 13:35:50',
                'updated_at'     => '2019-05-09 13:35:50',
            ]
        ];
        Participant::insert($participants);


        //-----------------------------------------------------------------
        // Support Workers Seeding
        $sw = 
            [
                [
                    'user_id'       => 4,
                    'address'       => '15 Pleasant Ave, Erskineville NSW 2043, Australia',
                    'lat'           => '-33.9029271',
                    'lng'           => '151.1823562',
                    'is_onboarding_complete' => 1,
                    'agreement_signed' => 1,
                    'created_at'    => '2019-05-09 13:35:50',
                    'updated_at'    => '2019-05-09 13:35:50',
                ]
            ];
        SupportWorker::insert($sw);

        //-----------------------------------------------------------------
        // External Service Provider Seeder
        $ext_ser_pvdr = [
            [
                'user_id'           => 5,
                'service_provided'  => 'Churchill Road, South Australia',
                'created_at'        => '2019-05-09 13:35:50',
                'updated_at'        => '2019-05-09 13:35:50',
            ]
        ];
        ServiceProvider::insert($ext_ser_pvdr);

    }
}
