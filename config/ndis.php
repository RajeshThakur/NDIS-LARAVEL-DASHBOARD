<?php
 
return [
    // Google Maps API Key
    'google_maps_key'  => env("GOOGLE_MAPS_KEY", "AIzaSyBpFHgnld11BottMtxVNY__16qoCXQEHsw"),
    'provider_role_id'  => env("PROVIDER_ROLE_ID", 2),
    'admin_role_id'  => env("ADMIN_ROLE_ID", 1),
    'participant_role_id'  => env("PARTICIPANT_ROLE_ID", 3),
    'support_worker_role_id'  => env("SUPPORT_WORKER_ROLE_ID", 4),
    'external_service_role_id'  => env("EXT_SERVICE_PROVIDER_ROLE_ID", 5),
    'app_roles_allowed'  => env("APP_ROLES_ALLOWED", '3,4'),
    'AWS_BUCKET'  => env('AWS_BUCKET', 'ndiscentral'),
    'AWS_DEFAULT_REGION'  => env('AWS_DEFAULT_REGION', 'ap-southeast-2'),
    'AWS_URL'  => env('AWS_URL', 'https://ndiscentral.s3.ap-southeast-2.amazonaws.com'),

    'applink' => [
            'ios' => 'https://ndiscentral.org.au/',
            'android' => 'https://ndiscentral.org.au/',
    ],
    'booking' => [
                    'statuses' => [
                                    'Scheduled' => 'Scheduled',
                                    'Cancelled' => 'Cancelled',
                                    'Started' => 'Started',
                                    'NotSatisfied' => 'NotSatisfied',
                                    'Approved' => 'Approved',
                                    'Submitted' => 'Submitted',
                                    'Paid' => 'Paid',
                                    'Pending' => 'Pending'
                        ],
                    'cancel_lock_in_period' => 24,       // In hours
                    'process_wait_time' => 60,       // In minutes
                    'early_checkin_time' => 5,       // In minutes
                    'manual' =>[
                                'meta_key' =>[
                                    'comment' => 'manual_comment',
                                    'reason' => 'booking_incompletion_reason',
                                    'quote' => 'quote_required',
                                    'external_invoice' => 'external_invoice_id'
                                ]
                    ],
                    'reschedule' => [
                        'identifier' => 'reschedule_request',
                        'wait_response' => 48, // In Hours
                    ]

                ],
    'notification' => [
        'agreement_time_gap' => 7, // in Days
    ],

    'stripe_key' => env("STRIPE_KEY", "pk_test_ueno4o3j0HhdZ1pufKistEit00oAQjMnWE"),
    'stripe_secret' => env("STRIPE_SECRET", "sk_test_dASrdFiIzXEIrCrh9F7rYIdJ00OMd9lK3X"),
    'stripe_product' => env("STRIPE_PRODUCT", "prod_G5itkWzk5sNkpo"),
    'stripe_plan' => env("STRIPE_PLAN", "plan_G66YbmoBRoBkek"),

    'forms' => [
            'particpant_agreement_id' => 11,
            'support_worker_agreement_id' => 13,
            'guardian_agreement_id' => 1,
            'frequency' => [
                'oneoff' => 'One off',
                'weekly' => 'Weekly',
                'casual' => 'Casual'            
            ],
    ],
    'reports' => [
        'service_booking_by_sw' => [
            'support_worker' => 'Support Worker',
            'service_provider' => 'Service Provider'
        ],
    ]
                

];