<?php
    return [
        'general_error'   => "Hmm. Something went wrong. Please try again",
        'internal_error'  => "Something went wrong. Please refresh the page and try again.",
        'invalid_address' => "Please enter a valid address",
        'email'           => 'Please enter your email address',
        'email_format'    => 'Please enter valid email address',
        'pass'            => 'Please enter your password',
        'pass_length'     => "Password Must be minimum 6 character long",
        'pass_confirm'    => 'Please confirm your password',
        'pass_mismatch'   => 'Passwords do not match please try again',
        'pass_token'      => 'Your token seems to be expired. Please request a new token',


        'register' => [
            'fname'          => 'Please enter your first name',
            'lname'          => 'Please enter your last name',
            'email'          => 'Please enter your email address',
            'email_format'   => 'Please enter valid email address',
            'pass'           => 'Please enter your password',
            'pass_length'    => "Password Must be minimum 6 character long",
            'confirm'        => 'Please confirm your password',
            'business'       => 'Please enter your business name',
            'renewal'        => 'Please enter your NDIS Agreement renewal date',
            'org_id'         => 'Please enter a valid Organisation ID',
            'org_id_invalid' => 'Please enter a valid Organisation ID',
            'ra_number'      => 'Please enter a valid RA Number',
            'ndis_cert'      => 'Your NDIS Certificate is required to sign up',
            'terms'          => 'You must agree to our Terms & Conditions in order to sign up',
            'date_format'    => "Please enter a valid date"
        ],

        'externalservice' => [
            'first_name'        => 'Service Provider first name requried',
            'last_name'         => 'Service Provider last name requried',
            'email'             => 'Service Provider email requried',
            'email_format'      => 'Please enter valid email address',
            'mobile'            => 'Service Provider mobile no requried',
            'mobile_minlength'  => 'Mobile number should be 10 digits minimum',
            'address'           => 'Service Provider address requried'
        ],


        "participants" => [
            "first_name"             => "Participant first name is required",
            "last_name"              => "Participant last name is required",
            "email"                  => "Participant email address is required",
            "email_format"           => "Please enter valid email address",
            "ndis_number"            => "NDIS number required",
            "address"                => "Participant address required",
            "start_date_ndis"        => "Start date required",
            "start_date_ndis_format" => "Please enter a valid date",
            "end_date_ndis"          => "End date required",
            "end_date_ndis_format"   => "Please enter a valid date",
            
            
        ],


        "support_worker" => [
            "first_name"           => "Support Worker first name required",
            "last_name"            => "Support Worker last name required",
            "email"                => "Support Worker email address required",
            "mobile"               => "Support Worker mobile no required",
            "address"              => "Support Worker address required",
            "registration_groups"  => "Support Worker Registration group selection required",
        ],

        "messanger"=> [
            "message"           => "Message field is required",
            "subject"           => "Subject field is required",
        ],

        "service_booking" => [
            "first_name" => "First name is required",
            "last_name" => "Last name is required",
            "email" => "Email address is required",
            "address" => "Location is required",
            "registration_groups" => "Registration group/s required",
        ],


        "permissions" => [
            "title" => "Title is required",
        ],


        "role" => [
            "title" => "Title is required",
            "permissions" => "Permissions are required", 
        ],


        "user" => [
            "name" => "Name is required",
            "email" => "Email address is required",
            // "email.unique:users,email" => "Email address is required",
            "password" => "Password is required",
            "size2" => "Size is required",
            "roles" => " Role is required", 
            "business" => " Business name is required", 
        ],

        "task_status" => [
            "name" => "Name is required",
        ],

        "task_tags_edit" => [
            "name" => "Name is required",
        ],

        "task_create" => [
            "name" => "Event title is required",
            "location" => "Location is required",
            "description" => "Description is required",
            "task_assignee_id" => "Task Assignee is required",
            "status_id" => "Status ID is required",
        ],

        "registration_group_edit" => [
            "title" => "Title is required",
            "item_number" => "Item number is required",
            "price_limit" => "Price limit is required",
            "parent_id" => "Parent ID is required",
            "status" => "Status is required",
        ],
        "registration_group_create" => [
            "title" => "Title is required",
            "status" => "Status is required",
        ],

        "registration_group" => [
            "title"          => "Title is required",
            "status"         => "Status is required",
            "item_number"    =>"Item Number is required",
            "price_limit"    =>"Price Limit is required"
        ],

        "support_worker_edit" => [
            "first_name" => "First name is required",
            "last_name" => "Last name is required",
            "email" => "Email address is required",
            "mobile" => "Mobile number is required",
            "address" => "Address is required",
            "address_lat" => "Please Enter The Valid Address",
            "registration_groups" => "Registration group/s is required",
        ],

        "event" => [
            "event_title"      => "Event Title is required",
            "due_date"         => "Due Date is required",
            "due_date_formet"  => "Date must be displayed as dd/mm/yyyy",
            'start_time'       => 'Event Start Time required',
            'start_time_format'=> 'Please enter valid time',
            'end_time'         => 'Event End Time is required',
            'end_time_format'  => 'Please enter valid time',
            "location"         => "Location is required",
            "task_assignee_id" => "Invite The user required",
            "color"            => "Color is required",
            "status"           => "Status is required",
            "description"      => "Description is required",
        ],

        "service_booking" => [

            'participant_id'    => 'Participant is required',
            'location'          => 'Location is required',
            'lat'               => 'lat is required',
            'lng'               => 'lng is required',
            "date"              => "date required",
            "date_format"       => "Date must be displayed as dd/mm/yyyy",
            'start_time'        => 'start time required',
            'start_time_format' => 'Please enter valid time',
            'end_time'          => 'end time is required',
            'end_time_format'   => 'Please enter valid time',
            'registration_group_id' => 'Registration group/s is required',
            'item_number'           => 'Item number is required',
            'supp_wrkr_ext_serv_id' => 'Support Worker information is required',
            'suport_wrkr_not'   =>  'No support worker is selected',
        ],

        "note" => [
            "description_missing" => "There is currently no description available",
        ],

        "content_category_edit" => [

            'name' => 'Name is required',
            
        ],

        "content_category_create" => [

            'name' => 'Name is required',  
        ],

        "content_tag_create" => [

            'name' => 'Name is required',  
        ],

        "content_tag_edit" => [

            'name' => 'Name is required',  
        ],

        "content_page_create" => [

            'title' => 'Title is required',  
            'categories' => 'Categories is an array',  
            'tags' => 'Tags is an array',  
        ],
        "content_page_edit" => [

            'title' => 'Title is required',   
        ],

        "external_service_provider_edit" => [
            "first_name" => "First name is required",
            "last_name" => "Last name is required",
            "email" => "Email address is required",
            "mobile" => "Mobile No. is required",
            "address" => "Address is required",
            "lat" => "Please inter a valid address",
        ],


        'opform' => [
            'guardian' => [
                'email_required' => 'Guardian email address is required',
                'email_exists' => 'Guardian email alread exists please use any other email',
            ],
            'dob' => 'Client\'s date of birth is required',
            'dob_invalid' => 'Please enter a valid date of birth to continue',
            'participant_name' => "Participant name is required",
            'advocate_address' => "Adovcate address is required",
            'risk_assessment' => [
                'bg_info' => "Please provide some background info",
                'date_required' => "Risk assessment date is required",
                'name_conducting' => "Name of the person conducting assessment is required",
            ],
        ],

        "user_management" =>[
            'permission_title' => 'Title is required',
            'roles_title'      => 'Title is required',
            'user_name'        => 'Name is required',
            'user_first_name'  => 'First Name is required',
            'user_last_name'   => 'Last Name is required',
            'user_email'       => 'Email is required',
            'user_password'    => 'Password is required',
        ],

        "event_management" =>[
            'tags_name'       => 'Name is required',
            'roles_title'     => 'Title is required',
            'user_name'       => 'Name is required',
            'user_first_name' => 'First Name is required',
            'user_last_name'  => 'Last Name is required',
            'user_email'      => 'Email is required',
            'user_password'   => 'Password is required',
        ],

        "participant_add_new_document" =>[
            'title'     => 'Title is required',
            'document'  => 'Document is required',
        ],

        "participant_notes" =>[
            'topic'             => 'Topic is required',
            'note_description'  => 'Note Description is required',
        ],

        "support_worker_notes" =>[
            'topic'             => 'Topic is required',
            'note_description'  => 'Note Description is required',
        ],

        "content_category" =>[
            'category_name'             => 'Name is required',
            'tag_name'             => 'Name is required',
            'page_title'             => 'Title is required',
        ]

        

    ];


?>
