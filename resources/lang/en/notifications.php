<?php

return [
        'title'                         => 'Documents',
        'participant_ndis_plan'         => [
                                                'participant' =>[                                                
                                                                'subject'   => [
                                                                                'month'     => 'Plan renewal is due',
                                                                                'week'      => 'Plan renewal is due',
                                                                                'day'       => 'Plan renewal is due',
                                                                                'expired'   => 'Plan is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Your NDIS plan is going to expire in 1 month',
                                                                                'week'      => 'Your NDIS plan is going to expire in 1 week',
                                                                                'day'       => 'Your NDIS plan is going to expire in 1 day',
                                                                                'expired'   => 'Your NDIS plan has expired',
                                                                        ],
                                                ],
                                                'provider' =>[                                                
                                                                'subject'  => [
                                                                                'month'     => ':Name\'s plan renewal is due',
                                                                                'week'      => ':Name\'s plan renewal is due',
                                                                                'day'       => ':Name\'s plan renewal is due',
                                                                                'expired'   => ':Name\'s plan is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Participant NDIS Plan for :name is due to expire in 1 month ',
                                                                                'week'      => 'Participant NDIS Plan for :name is due to expire in 1 week',
                                                                                'day'       => 'Participant NDIS Plan for :name is due to expire in 1 day',
                                                                                'expired'   => 'Participant NDIS Plan for :name is expired',
                                                                        ],
                                                ]
        ],

        'participant_agreement'         => [
                                                'participant' =>[
                                                                'subject'   => [
                                                                                'month'     => 'Your Service Agreement renewal is due',
                                                                                'week'      => 'Your Service Agreement renewal is due',
                                                                                'day'       => 'Your Service Agreement renewal is due',
                                                                                'expired'   => 'Your Service Agreement is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Your Service Agreement is going to expire in 1 month',
                                                                                'week'      => 'Your Service Agreement is going to expire in 1 week',
                                                                                'day'       => 'Your Service Agreement is going to expire in 1 day',
                                                                                'expired'   => 'Your Service Agreement has expired',
                                                                        ],
                                                ],
                                                'provider' =>[                                                
                                                                'subject'  => [
                                                                                'month'     => ':Name\'s Service Agreement renewal is due',
                                                                                'week'      => ':Name\'s Service Agreement renewal is due',
                                                                                'day'       => ':Name\'s Service Agreement renewal is due',
                                                                                'expired'   => ':Name\'s Service Agreement is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Service Agreement for Participant :name is due to expire in 1 month',
                                                                                'week'      => 'Service Agreement for Participant :name is due to expire in 1 week',
                                                                                'day'       => 'Service Agreement for Participant :name is due to expire in 1 day',
                                                                                'expired'   => 'Service Agreement for Participant :name is expired',
                                                                        ],
                                                ]
        ],

        'worker_agreement'         => [
                                                'worker' =>[
                                                                'subject'   => [
                                                                                'month'     => 'Your Contract renewal is due',
                                                                                'week'      => 'Your Contract renewal is due',
                                                                                'day'       => 'Your Contract renewal is due',
                                                                                'expired'   => 'Your Contract is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Your Contract with Provider is going to expire in 1 month',
                                                                                'week'      => 'Your Contract with Provider is going to expire in 1 week',
                                                                                'day'       => 'Your Contract with Provider is going to expire in 1 day',
                                                                                'expired'   => 'Your Contract with Provider has expired',
                                                                        ],
                                                ],
                                                'provider' =>[                                                
                                                                'subject'  => [
                                                                                'month'     => ':Name\'s Contract renewal is due',
                                                                                'week'      => ':Name\'s Contract renewal is due',
                                                                                'day'       => ':Name\'s Contract renewal is due',
                                                                                'expired'   => ':Name\'s Contract is expired',
                                                                        ],
                                                                'msg'   => [
                                                                                'month'     => 'Contract for Support Worker :name is due to expire in 1 month',
                                                                                'week'      => 'Contract for Support Worker :name is due to expire in 1 week',
                                                                                'day'       => 'Contract for Support Worker :name is due to expire in 1 day',
                                                                                'expired'   => 'Contract for Support Worker :name is expired',
                                                                        ],
                                                ]
        ],
        'policy_updated'        =>[

                                      'subject' => 'Policy and Procedures has been updated',
                                      'msg'     => 'Policy and Procedures has been updated'

        ],
        'provider_ndis_plan'         =>[
                                        'subject'   => [
                                                'month'     => 'Your NDIS plan renewal is due',
                                                'week'      => 'Your NDIS plan renewal is due',
                                                'day'       => 'Your NDIS plan renewal is due',
                                                'expired'   => 'Your NDIS plan is expired',
                                        ],
                                        'msg'   => [
                                                'month'     => 'Your NDIS plan is going to expire in 1 month',
                                                'week'      => 'Your NDIS plan is going to expire in 1 week',
                                                'day'       => 'Your NDIS plan is going to expire in 1 day',
                                                'expired'   => 'Your NDIS plan has expired',
                                        ],
        ]
];
