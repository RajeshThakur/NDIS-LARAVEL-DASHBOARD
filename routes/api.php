<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {


    Route::post('login', 'UsersApiController@login')->name('login');
    
    Route::post('register', 'UsersApiController@register')->name('register');

    // Route::middleware('guest')->group(function () {
        Route::post('forgot', 'ForgotPasswordApiController@sendResetLinkEmail')->name('forgot');
    // });
    
    Route::middleware('auth:api')->group(function () {

        Route::group(['middleware' => ['apiauthcheck']], function () {
            
            Route::post('logout', 'UsersApiController@logout')->name('logout');

            // Push Token Subscribe
            Route::post('subscribe', 'UsersApiController@subscribe')->name('subscribe');

            //Update User Profile
            Route::post('update-profile', 'UsersApiController@update')->name('update-profile');

            //Upload documents
            // Route::get('get-document', 'DocumentsApiController@getDocument')->name('get-document');
            Route::post('document/upload', 'DocumentsApiController@upload')->name('document-upload');

            Route::get('get-notifications', 'NotificationsApiController@getAll')->name('notifications');

            Route::get('forms/view/{id}/{isParticipantTrue?}', 'OperationalFormsApiController@view')->name('forms.view');


            //---------------------------------------------
            // Messages API routes
            Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {

                Route::get('list', 'MessagesApiController@list')->name('list');
                Route::get('single/{id}', 'MessagesApiController@singleThread')->name('single');
                Route::put('comment', 'MessagesApiController@addComment')->name('comment');

                Route::post('create', 'MessagesApiController@createThread')->name('create');
                Route::get('messagable', 'MessagesApiController@getMessagable')->name('messagable');

                Route::get('search', 'MessagesApiController@searchMessage')->name('search');

            });

            //Registration groups
            Route::get('/registration-groups', 'UsersApiController@getRegistrationGroups')->name('registration-groups');  //user reg groups


            //---------------------------------------------
            // Bookings API routes
            Route::group(['prefix' => 'bookings', 'as' => 'bookings.', 'middleware' => ['bookingverify']], function () {

                Route::post('checkin', 'BookingsApiController@checkin')->name('checkin');
                Route::post('checkout', 'BookingsApiController@checkout')->name('checkout');
                Route::post('reschedule', 'BookingsApiController@reschedule')->name('reschedule');
                Route::post('reschedule/response', 'BookingsApiController@rescheduleResponse')->name('reschedule.response');
                Route::post('cancel', 'BookingsApiController@cancelBooking')->name('cancel');


                //Booking-incidents
                Route::get('{booking_order_id}/incidents', 'BookingsApiController@getBookingIncidents')->name('incidents');            

                //Booking-Complaints
                Route::get('{booking_order_id}/complaints', 'BookingsApiController@getBookingComplaints')->name('complaints');

                //Notes
                Route::get('{booking_order_id}/notes', 'BookingsApiController@getNotes')->name('notes');
                Route::post('note/create', 'BookingsApiController@addNote')->name('note.add');

                //message routes
                Route::post('message','BookingsApiController@message')->name('message');

                Route::get('{booking_order_id}/list','BookingsApiController@getThreadList')->name('list');

            });


            //---------------------------------------------
            // Participants Module
            Route::group(['prefix' => 'participants', 'as' => 'participants.', 'middleware' => ['onlyparticipant']], function () {

                Route::post('onboarding', 'ParticipantsApiController@onboarding')->name('onboarding');

                Route::get('profile', 'ParticipantsApiController@getProfile')->name('profile');
                Route::put('update', 'ParticipantsApiController@updateProfile')->name('update');
                Route::post('update-avatar', 'ParticipantsApiController@updateAvatar')->name('update-avatar');

                //Availablity
                Route::get('availabilities', 'ParticipantsApiController@getAvailability')->name('availabilities');
                Route::post('create-availability', 'ParticipantsApiController@createAvailability')->name('create-availability');
                Route::put('update-availability/{id}', 'ParticipantsApiController@updateAvailability')->name('update-availability');
                Route::delete('delete-availability/{id}', 'ParticipantsApiController@deleteAvailability')->name('delete-availability');

                //Bookings
                Route::get('bookings', 'ParticipantsApiController@getBookings')->name('bookings');
                Route::get('bookings/{id}', 'ParticipantsApiController@getBooking')->name('booking.get');

                //Agreements
                Route::get('agreements', 'ParticipantsApiController@getAgreements')->name('agreements');
                Route::put('agreement/{id}', 'ParticipantsApiController@updateAgreement')->name('agreement');

                //Complaints
                Route::post('/complaint', 'BookingsApiController@createComplaint')->name('complaint.save');  // Create new complaint
                Route::post('/complaint/comment', 'BookingsApiController@addComplaintComment')->name('complaint.comment');  //Add comment to complaint
                Route::get('/complaints', 'BookingsApiController@getUserComplaints')->name('complaints');  //All complaints by user
                Route::get('/complaints/byme', 'BookingsApiController@getComplaintsByUser')->name('complaints.byme');  //All complaints created by user for booking
                
                //transactions
                Route::get('transactions', 'ParticipantsApiController@getTransactions')->name('transactions');

                //support worker
                Route::get('supportworker', 'ParticipantsApiController@getSupportWorker')->name('supportworker');
                Route::get('supportworker/search', 'ParticipantsApiController@searchSupportWorker')->name('supportworker.search');

                //upload invoice
                Route::post('invoice/upload', 'ParticipantsApiController@uploadInvoice')->name('upload-invoice');


                //financial information
                Route::get('funds/total', 'ParticipantsApiController@getTotalAllocatedFunds')->name('funds-total');
                Route::get('funds/remaining', 'ParticipantsApiController@getTotalRemainingFunds')->name('funds-remaining');
                Route::get('funds/group', 'ParticipantsApiController@getAllocatedRegGroupFunds')->name('funds-group');
                Route::get('funds/group/remaining', 'ParticipantsApiController@getRemainingRegGroupFunds')->name('funds-group-remaining');
                Route::get('funds/paid/services', 'ParticipantsApiController@getPaidServicesList')->name('funds-paid-services');
                Route::get('funds/detail', 'ParticipantsApiController@getFundsDetail')->name('funds-detail');


                //forms
                // Route::get('form/pdf/{id}', 'OperationalFormsApiController@getFormPdf')->name('form-pdf');

                Route::get('form/1', 'OperationalFormsApiController@getTemplateOne')->name('form-one');
                Route::get('form/2', 'OperationalFormsApiController@getTemplateTwo')->name('form-two');
                Route::get('form/3', 'OperationalFormsApiController@getTemplateThree')->name('form-three');
                Route::get('form/4', 'OperationalFormsApiController@getTemplateFour')->name('form-four');
                Route::get('form/5', 'OperationalFormsApiController@getTemplateFive')->name('form-five');
                Route::get('form/6', 'OperationalFormsApiController@getTemplateSix')->name('form-six');
                Route::get('form/7', 'OperationalFormsApiController@getTemplateSeven')->name('form-seven');
                Route::get('form/9', 'OperationalFormsApiController@getTemplateNine')->name('form-nine');
                Route::get('form/10', 'OperationalFormsApiController@getTemplateTen')->name('form-ten');
                Route::get('form/11', 'OperationalFormsApiController@getTemplateEleven')->name('form-eleven');

                Route::post('form/1', 'OperationalFormsApiController@updateTemplateOne')->name('form-one');
                Route::post('form/2', 'OperationalFormsApiController@updateTemplateTwo')->name('form-two');
                Route::post('form/3', 'OperationalFormsApiController@updateTemplateThree')->name('form-three');
                Route::post('form/4', 'OperationalFormsApiController@updateTemplateFour')->name('form-four');
                Route::post('form/5', 'OperationalFormsApiController@updateTemplateFive')->name('form-five');
                Route::post('form/6', 'OperationalFormsApiController@updateTemplateSix')->name('form-six');
                Route::post('form/7', 'OperationalFormsApiController@updateTemplateSeven')->name('form-seven');
                Route::post('form/9', 'OperationalFormsApiController@updateTemplateNine')->name('form-nine');
                Route::post('form/10', 'OperationalFormsApiController@updateTemplateTen')->name('form-ten');
                Route::post('form/11', 'OperationalFormsApiController@updateTemplateEleven')->name('form-eleven');
               
               


            });


            //---------------------------------------------
            // Support Worker API routes
            Route::group(['prefix' => 'support-worker', 'as' => 'support-worker.', 'middleware' => ['onlysupportworker']], function () {

                //Profile
                Route::get('profile', 'SupportWorkerApiController@getProfile')->name('profile');
                Route::put('update', 'SupportWorkerApiController@updateProfile')->name('update');
                Route::post('update-avatar', 'SupportWorkerApiController@updateAvatar')->name('update-avatar');

                //Participants
                Route::get('participants', 'SupportWorkerApiController@getParticipants')->name('participants');
                Route::get('participants/search', 'SupportWorkerApiController@searchParticipants')->name('participants.search');

                //Bookings
                Route::get('bookings', 'SupportWorkerApiController@getBookings')->name('bookings');
                Route::get('bookings/{id}', 'SupportWorkerApiController@getBooking')->name('booking.get');
                // Route::post('bookings/{id}/checkin', 'SupportWorkerApiController@swBookingCheckin')->name('bookings-checkin');
                // Route::post('bookings/{id}/checkout', 'SupportWorkerApiController@swBookingCheckout')->name('bookings-checkout');

                //Availablity
                Route::get('availabilities', 'SupportWorkerApiController@getAvailability')->name('availabilities');
                Route::post('create-availability', 'SupportWorkerApiController@createAvailability')->name('create-availability');
                Route::put('update-availability/{id}', 'SupportWorkerApiController@updateAvailability')->name('update-availability');
                Route::delete('delete-availability/{id}', 'SupportWorkerApiController@deleteAvailability')->name('delete-availability');

                
                //Incidents
                Route::get('/incidents', 'BookingsApiController@getUserIncidents')->name('incidents');  //All sw incidents for booking
                Route::get('/incidents/byme', 'BookingsApiController@getIncidentsByUser')->name('incidents.byme'); //All incidents created by sw for booking
                Route::get('/incidents/{incident_id}', 'BookingsApiController@getIncident')->name('incident');  //Individual incident for booking
                Route::post('/incident', 'BookingsApiController@createIncident')->name('incident.save');  // Create new incident
                Route::post('/incident/comment', 'BookingsApiController@addComment')->name('incident.comment');  //Add comment to incident report

                 //Agreements
                Route::get('agreements', 'SupportWorkerApiController@getAgreements')->name('agreements');
                Route::put('agreement/{id}', 'SupportWorkerApiController@updateAgreement')->name('agreement');

                //Payouts
                Route::get('/payouts', 'SupportWorkerApiController@getPayouts')->name('payouts');  //All sw payouts

                //Forms
                Route::get('form/8', 'OperationalFormsApiController@getTemplateEight')->name('form-eight');
                Route::get('form/12', 'OperationalFormsApiController@getTemplateTwelve')->name('form-twelve');
                Route::get('form/13', 'OperationalFormsApiController@getTemplateThirteen')->name('form-thirteen');
                
                Route::post('form/8', 'OperationalFormsApiController@updateTemplateEight')->name('form-eight');
                Route::post('form/12', 'OperationalFormsApiController@updateTemplateTwelve')->name('form-twelve');
                Route::post('form/13', 'OperationalFormsApiController@updateTemplateThirteen')->name('form-thirteen');

            });


        });    

    });
});


Route::fallback('Api\V1\Admin\ErrorApiController@fallback');