<?php

use Illuminate\Http\Request;

//Public Routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/success', 'HomeController@success')->name('success');
Route::get('clear', 'HomeController@clearCache');

//testing Routes
Route::get('test/form', 'HomeController@form')->name('test.form');
Route::get('test/sentry', 'HomeController@sentry_debug')->name('sentry');
Route::get('test/queue', 'HomeController@testQueue')->name('queue');
Route::get('test/decode', 'HomeController@decode')->name('decode');
Route::get('test/push', 'HomeController@push_test')->name('push');
Route::get('test/ses', 'HomeController@ses_test')->name('test.ses');
Route::get('test/smtp', 'HomeController@smtp_test')->name('test.smtp');
Route::get('test/log', 'HomeController@testLog')->name('test.log');

Route::get('/testview', 'HomeController@testview');

//Ajax Session Checker
Route::get('/session/check', 'HomeController@session_checker')->name('session.check');

//Redirect /home to dashboard
Route::redirect('/home', '/admin');

Auth::routes();

Route::get('activate/{token}', 'Auth\RegisterController@activate')->name('activate');

Route::post('activate', 'Auth\RegisterController@activateUser')->name('activate.user');

//activate the participant advocate(guardian)

Route::get('activate-advocate/{token}', 'Auth\RegisterController@activateAdvocate')->name('activate-advocate');

Route::post('activate-advocate_account', 'Auth\RegisterController@activateAdvocateAccount')->name('activate.gaurdian');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','provider']], function () {
    
    //---------------------------------------------
    // Dashboard
    Route::delete('notification/{id}', 'DashboardController@deletenotification')->name('delete.notification');


    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('/onboard', 'DashboardController@onboard')->name('onboard');
    Route::get('/overdue-tasks', 'DashboardController@overdueTasks')->name('overdue-tasks');
    Route::get('/upcoming-partcipant-bookings', 'DashboardController@upcomingParticipantBookings')->name('upcoming-partcipant-bookings');
    Route::get('/incomplete-bookings', 'DashboardController@incompleteBookings')->name('incomplete-bookings');
    Route::get('/partcipants-without-booking', 'DashboardController@participantsWithoutBooking')->name('partcipants-without-booking');
    Route::post('/update-event-date', 'DashboardController@updateEventDate')->name('update-event-date');

    //Route for creating and testing an admin view
    Route::get('/testview', 'DashboardController@testview');

    Route::get('/invoice/{invoice}', 'InvoiceController@downloadInvoice' )->name('invoice');

    //---------------------------------------------
    // Subscriptions
    Route::get('subscription', 'SubscriptionController@index')->name('subscription');
    Route::get('subscription/addcard', 'SubscriptionController@addCard')->name('subscription.addcard');  //add card view
    Route::post('subscription/method', 'SubscriptionController@ajaxAddMethod')->name('subscription.method'); //add card to stripe
    Route::post('subscription/defaultcard', 'SubscriptionController@defaultCard')->name('subscription.defaultcard'); //make card default
    Route::post('subscription/removecard', 'SubscriptionController@removeCard')->name('subscription.removecard'); //remove card 
    Route::get('subscription/billinginfo', 'SubscriptionController@billingInfo')->name('subscription.billinginfo'); 
    Route::post('subscription/updatebillinginfo', 'SubscriptionController@updateBillingInfo')->name('subscription.updatebillinginfo'); // update billinginfo
    Route::get('subscription/plans', 'SubscriptionController@availablePlans')->name('subscription.plans'); // avaiable plans
    Route::post('subscription/subscribe', 'SubscriptionController@subscribeToPlan')->name('subscription.subscribe'); // subscribe to plan

    //---------------------------------------------
    // Notifications
    Route::get('notifications', 'DashboardController@notifications')->name('notifications');  

    //---------------------------------------------
    // User / Permissions / Roles related

    Route::resource('permissions', 'PermissionsController');

    Route::resource('roles', 'RolesController');

    Route::get('users/profile', 'UsersController@profile')->name('users.profile');

    Route::put('users/profile/update', 'UsersController@profile_update')->name('users.profile.update');

    Route::put('users/reg/update', 'UsersController@reg_update')->name('users.reg.update');

    Route::post('users/avatar', 'UsersController@saveAvatar')->name('users.avatar');

    Route::get('provider/rates', 'UsersController@editRates')->name('provider.rates');

    Route::resource('users', 'UsersController');

    //---------------------------------------------
    // Tasks & Events
    Route::resource('events', 'TaskController');

    Route::group(['prefix' => 'events', 'as' => 'events.'], function () {

        Route::resource('statuses', 'TaskStatusController');

        Route::get('calendar', 'TasksCalendarController@index')->name('calendar');

    });

    Route::get('tasks/statuses', 'TaskStatusController@index')->name('tasks.statuses.index');

    Route::resource('task-tags', 'TaskTagController');

    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    
    Route::resource('time-reports', 'TimeReportController');

    

    //---------------------------------------------
    // Availability Module
    Route::match(['put','post'], 'availability/save', 'AvailabilitiesController@ajax_save')->name('availability.save');
    Route::delete('availability/destroy', 'AvailabilitiesController@ajax_remove')->name('availability.destroy');


    //---------------------------------------------
    // Participants Module

    Route::match(['get'], 'participants/{id}/documents', 'ParticipantsController@documents')->name('participants.documents');

    Route::match(['get'], 'participants/{id}/documents/new', 'ParticipantsController@document_new')->name('participants.documents.new');
    
    Route::match(['put'], 'participants/{id}/documents/save', 'ParticipantsController@document_save')->name('participants.documents.save');

    Route::match(['get'], 'participants/{id}/availability', 'ParticipantsController@availability')->name('participants.availability');

    Route::match(['put','post'], 'participants/{id}/availability/save', 'ParticipantsController@ajax_availability')->name('participants.availability.save');

    Route::match(['get', 'put'], 'participants/{id}/bookings', 'ParticipantsController@bookings')->name('participants.bookings');

    Route::match(['get'], 'participants/{id}/notes', 'ParticipantsController@notes')->name('participants.notes');

    Route::match(['put'], 'participants/{id}/notes/save', 'ParticipantsController@notes_save')->name('participants.notes.save');

    Route::match(['get'], 'participants/{id}/onboarding', 'ParticipantsController@onboarding')->name('participants.onboarding');

    Route::match(['post'], 'participants/steps', 'ParticipantsController@onboarding_steps')->name('participants.steps');

    Route::match(['post'], 'participants/onboarding/validate', 'ParticipantsController@onboarding_validate')->name('participants.onboarding.validate');

    // Route::match(['put'], 'participants', 'ParticipantsController@index')->name('participants.index');

    Route::resource('participants', 'ParticipantsController');


    //---------------------------------------------
    // Registration Groups Module

    Route::match(['get'], 'registration/groups/child', 'RegistrationGroupsController@getParentChilds')->name('registration.groups.child');

    Route::resource('registration-groups', 'RegistrationGroupsController');

    Route::get( '/getRegGroups', 'RegistrationGroupsController@getChildList');


    //---------------------------------------------
    // Documents Module

    Route::post('documents/save', 'DocumentsController@store')->name('documents.save');

    Route::resource('documents', 'DocumentsController');


    //---------------------------------------------
    //Operational Forms
    Route::get('forms/importfile', 'OperationalFormsController@importFile')->name('forms.importFile');

    Route::get('forms/create/{templateId}/{user_id}/{isParticipantTrue?}', 'OperationalFormsController@create')->name('forms.create');

    Route::get('forms/{form}/edit/{isParticipantTrue?}', 'OperationalFormsController@edit')->name('forms.edit');
    Route::get('forms/{form}/view/{isParticipantTrue?}', 'OperationalFormsController@view')->name('forms.view');
    

    Route::post('sa/reg/table', 'OperationalFormsController@ajaxSARegGrpTable')->name('sa.reg.table');

    Route::post('sa/reg/items', 'OperationalFormsController@ajaxSARegGrpItems')->name('sa.reg.items');

    Route::post('sign/save', 'OperationalFormsController@storeSign')->name('sign.save');

    Route::resource('forms', 'OperationalFormsController', ['except' => ['create','edit']]);


    //---------------------------------------------
    // Support Workers

    // Route::match(['post'], 'support-workers/{id}/uploadImage', 'SupportWorkerController@uploadImage')->name('support-workers.uploadImage');

    Route::match(['get'], 'support-workers/{id}/documents', 'SupportWorkerController@documents')->name('support-workers.documents');
    
    Route::match(['get'], 'support-workers/{id}/documents/new', 'SupportWorkerController@document_new')->name('support-workers.documents.new');
    
    Route::match(['put'], 'support-workers/{id}/documents/save', 'SupportWorkerController@document_save')->name('support-workers.documents.save');
    
    Route::match(['get', 'put'], 'support-workers/{id}/availability', 'SupportWorkerController@availability')->name('support-workers.availability');
    
    Route::match(['get', 'put'], 'support-workers/{id}/bookings', 'SupportWorkerController@bookings')->name('support-workers.bookings');
    
    Route::match(['get'], 'support-workers/{id}/notes', 'SupportWorkerController@notes')->name('support-workers.notes');
    
    Route::match(['put'], 'support-workers/{id}/notes/save', 'SupportWorkerController@notes_save')->name('support-workers.notes.save');
    
    Route::match(['get'], 'support-workers/{id}/linked-participants', 'SupportWorkerController@linkedParticipants')->name('support-workers.linked-participants');
    
    Route::match(['get', 'put'], 'support-workers/{id}/payment-history', 'SupportWorkerController@paymentHistory')->name('support-workers.payment-history');

    Route::match(['post'], 'support-workers/steps', 'SupportWorkerController@onboarding_steps')->name('support-workers.steps');

    Route::match(['post'], 'support-workers/onboarding/validate', 'SupportWorkerController@onboarding_validate')->name('support-workers.onboarding.validate');
    
    Route::resource('support-workers', 'SupportWorkerController');
    


    //---------------------------------------------
    // External Service Providers

    Route::match(['get'], 'service/provider/{id}/documents', 'ServiceProviderController@documents')->name('provider.documents');

    Route::match(['post'], 'service/provider/steps', 'ServiceProviderController@onboarding_steps')->name('provider.steps');

    Route::match(['post'], 'service/provider/onboarding/validate', 'ServiceProviderController@onboarding_validate')->name('provider.onboarding.validate');

    Route::resource('service/provider', 'ServiceProviderController');


    //---------------------------------------------
    // Service Bookings

    Route::resource('bookings', 'BookingsController')->only([
        'index', 'update', 'destroy'
    ]);

    Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], function () {

        Route::get('create/{editParticipantId?}', 'BookingsController@create')->name('create');
        Route::get('manually/complete/list', 'BookingsController@manuallyCompleteList')->name('manually-complete.list');
        Route::get('{id}/manually/complete', 'BookingsController@manuallyCompleteShow')->name('manually-complete.show');
        Route::put('{id}/manually/complete', 'BookingsController@manuallyComplete')->name('manually-complete');

        Route::get('detail/{id}', 'BookingsController@show')->name('detail');


        // AJAX Routes for Booking
        Route::match(['get'], 'create-form', 'BookingsController@ajax_create_form')->name('create_form');
        Route::match(['post'], 'registration/items', 'BookingsController@ajax_registration_items')->name('registration.items');
        Route::match(['post'], 'participant/details', 'BookingsController@ajax_participant_details')->name('participant.details');
        Route::match(['post'], 'participant/availability', 'BookingsController@ajax_chk_participant_availability')->name('participant.availability');
        Route::match(['post'], 'participant/availability/time', 'BookingsController@ajax_check_availbale_time')->name('participant.availability.time');
        Route::match(['post'], 'participant/bookablesw', 'BookingsController@ajax_bookable_support_workers')->name('participant.bookablesw');
        Route::match(['get'], 'nearby_sw', 'BookingsController@ajax_nearby_sw')->name('nearby_sw');
        Route::match(['get'], 'participants_reg_grp', 'BookingsController@ajax_participant_reg_grp')->name('participants_reg_grp');

        Route::match(['post','put'], 'store', 'BookingsController@ajax_store')->name('store');


        // Booking Page Tabs
        Route::match(['get'], '{id}/note', 'BookingsController@note')->name('edit.note');
        Route::match(['post','put'], '{id}/note/save', 'BookingsController@ajax_note_save')->name('edit.note.save');

        Route::match(['get'], '{id}/contact/participant', 'BookingsController@contact_participant')->name('edit.contact.participant');
        Route::match(['post','put'], '{id}/contact/participant/save', 'BookingsController@contact_participant_save')->name('edit.contact.participant.save');

        Route::match(['get'], '{id}/contact/worker', 'BookingsController@contact_worker')->name('edit.contact.worker');
        Route::match(['post','put'], '{id}/contact/worker/save', 'BookingsController@contact_worker_save')->name('edit.contact.worker.save');

        Route::match(['get'], '{id}/invoice', 'BookingsController@invoice')->name('edit.invoice');
        Route::match(['post','put'], '{id}/invoice/save', 'BookingsController@invoice_save')->name('edit.invoice.save');

        Route::match(['get'], '{id}/incident', 'BookingsController@incident')->name('edit.incident');
        Route::match(['post','put'], '{id}/incident/save', 'BookingsController@incident_save')->name('edit.incident.save');

        // Route::match(['get'], '{id}', 'BookingsController@edit')->name('edit');
        Route::match(['get'], '{orderid}', 'BookingsController@edit')->name('edit');
        Route::match(['get'], '{orderid}/show', 'BookingsController@show')->name('show');

    });
    



    //---------------------------------------------
    // Search
    
    Route::post('/search', 'SearchController@index');

    Route::get('/search-result', 'SearchController@searchByName')->name('search.name');


    // Route::post('complete-onboarding', 'ProviderController@completeOnboarding')->name('complete-onboarding');
    Route::resource('complete-onboarding', 'ProviderRegGroupsController');


    //Messages Group
    // Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    // Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    // Route::post('store', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    // // Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    // Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    // Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);

    Route::resource('messages', 'MessagesController');

    // Route::get('search-result/index', 'SearchByNameController@index')->name('search-result.index');


    //---------------------------------------------
    // Accounts
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {

        // Route::group(['prefix' => 'worker', 'as' => 'worker.'], function () {

            Route::match(['get'], '{name?}/timesheet/', 'AccountsController@workerTimesheet')->name('timesheet');
            Route::match(['get'], '{name?}/submission/', 'AccountsController@workerSubmissions')->name('submission');
            Route::match(['get'], '{name?}/payments/', 'AccountsController@workerPayments')->name('payments');
            Route::match(['get'], '{name?}/proda/', 'AccountsController@workerProda')->name('proda');
            Route::match(['get'], '{name?}/getTimesheet/{id}/', 'AccountsController@getProdaTimesheet')->name('getTimesheet');

            Route::match(['put'], '{name?}/timesheet_update/', 'AccountsController@workerTimesheet_update')->name('timesheet_update');
            Route::match(['put'], '{name?}/submission_update/', 'AccountsController@workerSubmission_update')->name('submission_update');


        // });
        
        // Route::group(['prefix' => 'external', 'as' => 'external.'], function () {

        //     Route::match(['get'], 'timesheet/{name?}', 'AccountsController@externalTimesheet')->name('timesheet');
        //     Route::match(['get'], 'submission/{name?}', 'AccountsController@externalSubmissions')->name('submission');
        //     Route::match(['get'], 'payments/{name?}', 'AccountsController@externalPayments')->name('payments');
        //     Route::match(['get'], 'proda/{name?}', 'AccountsController@externalProda')->name('proda');

        //     Route::match(['get','put'], 'accounts/worker', 'AccountsController@workerTimesheet')->name('timesheet.submit');

        // });
    });


    //---------------------------------------------
    // CMS
    Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {

        Route::resource('categories', 'ContentCategoryController');

        Route::resource('tags', 'ContentTagController');

        Route::resource('pages', 'ContentPageController');        

        Route::get('{slug}', 'ContentPageController@searchBySlug')->name('pages.search');

        Route::post('pages/media', 'ContentPageController@storeMedia')->name('pages.storeMedia');
    });



    //---------------------------------------------
    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
       
        Route::get('', 'ReportsController@index')->name('');

        Route::get('service-bookings', 'ReportsController@bookingsByTimeperiod')->name('service-bookings');
        Route::get('service-bookings/funding', 'ReportsController@serviceBookingFundings')->name('service-bookings.funding');

        Route::get('participants', 'ReportsController@participants')->name('participants');
        Route::get('participants/service-bookings', 'ReportsController@participantsBookings')->name('participants.service-bookings');
               
        Route::get('support-workers', 'ReportsController@supportWorkers')->name('support-workers');
        Route::get('support-workers/service-bookings', 'ReportsController@supportWorkersBookings')->name('support-workers.service-bookings');

        Route::get('service-workers', 'ReportsController@serviceWorkers')->name('service-workers');
       

    });


    Route::post('resend/mail/activation', 'UsersController@ajax_resendActivationMail')->name('resend.activation.email');


});


Route::group(['prefix' => 'autocomplete','namespace' => 'Admin','middleware' => ['auth']], function () {
      
    Route::post('/autocomplete/fetch', 'AutocompleteController@fetch')->name('autocomplete.fetch');

});



Route::group(['prefix' => 'errors'], function () {
    Route::get('/general', 'ErrorsController@index')->name('all');
});