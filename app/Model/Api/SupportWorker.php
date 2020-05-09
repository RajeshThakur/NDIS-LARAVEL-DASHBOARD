<?php

namespace App\Model\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Request;
use App\User;
use App\Bookings;

use App\Scopes\SWProviderScope;

class SupportWorker extends Model
{

    public $table = 'support_workers_details';
    

    public $timestamps = false;

    protected $hidden = [
        // 'password',
    ];

    protected $dates = [
        // 'created_at',
        // 'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'lat',
        'lng',
        'email',
        'address',
        'is_onboarding_complete',
        'onboarding_step'
    ];




    //-------------- Scope Local ----------------------
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReady($query)
    {
        // return $query->where('support_workers_details.is_onboarding_complete', 1)->where('support_workers_details.agreement_signed', 1);
        return $query->where('support_workers_details.is_onboarding_complete', 1);
    }


    //-------------- Core Overrides ----------------------

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getQualifiedKeyName();
    }

    //-------------- End of Core Overrides ----------------------
    

    /**
     * Get the participants
     */
    public function user()
    {
        return $this->hasOne('App\Model\Api\User', 'id');
    }


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Model\Api\Bookings', 'supp_wrkr_ext_serv_id');
    }

    // Relationship with Availabilities
    public function availability()
    {
        return $this->hasMany('App\Model\Api\Availability', 'user_id');
    }



    public static function providerSupportWorkers(){
        $user = \Auth::user();
        // pr($user->id,1);
        return SupportWorker::select('support_workers_details.*','users.*')->get();
        
    }

    public function getSupportWorker( $swID ) 
    {
        $user = \Auth::user();
        return SupportWorker::where('support_workers_details.user_id', $swID)
                    ->select('support_workers_details.*','users.*')->first();
    }

    public  function getLinkedParticipantsAndBookings( $swID ){
        $user = \Auth::user();
        // return "Information related to this section can only be displayed after completion of Service Booking module.";
        return Bookings::where('bookings.supp_wrkr_ext_serv_id', $swID)
                                ->leftJoin('users','users.id','=','bookings.participant_id')
                                ->select(   'bookings.location as booking_location',
                                            'bookings.id as booking_id',
                                            'bookings.item_number as booking_item_number',
                                            'booking_orders.starts_at as booking_start_date',
                                            'booking_orders.ends_at as booking_end_date',
                                            'bookings.service_type as booking_service_type',
                                            'bookings.participant_id as booking_participant_id',
                                            'bookings.supp_wrkr_ext_serv_id as booking_supp_wrkr_ext_serv_id', 
                                            'users.id as participant_id',
                                            'users.first_name as participant_fname',
                                            'users.last_name as participant_lname',
                                            'users.email as participant_email',
                                            'users.mobile as participant_mobile'
                                        )
                                ->get();
    }

    public  function getSearchedBookings( $swID,$request ){
       
        // return "Information related to this section can only be displayed after completion of Service Booking module.";
        // pr($request->all(),1);
        return Bookings::where([
                                        ['bookings.participant_id', '=', $request->get('member')],
                                        ['bookings.supp_wrkr_ext_serv_id', '=', $request->get('support_worker_id')],
                                    ])
                                ->whereDate('booking_orders.starts_at', '>=', $request->get('start_date'))
                                ->whereDate('booking_orders.ends_at', '<=', $request->get('end_date'))
                                ->leftJoin('users','users.id','=','bookings.participant_id')
                                ->select(
                                            'bookings.location as booking_location',
                                            'bookings.id as booking_id',
                                            'bookings.item_number as booking_item_number',
                                            'booking_orders.starts_at as booking_start_date',
                                            'booking_orders.ends_at as booking_end_date',
                                            'bookings.service_type as booking_service_type',
                                            'bookings.participant_id as booking_participant_id',
                                            'bookings.supp_wrkr_ext_serv_id as booking_supp_wrkr_ext_serv_id',
                                            'users.id as participant_id',
                                            'users.first_name as participant_fname',
                                            'users.last_name as participant_lname',
                                            'users.email as participant_email',
                                            'users.mobile as participant_mobile'
                                )
                                ->get();
    }

    public  function getPaymentHistory( $swID ){
        $user = \Auth::user();
        return "Information related to this section can only be displayed after completion of Payments module.";
    }

    public static function searchSupportWorkers( $query ){

        $user = \Auth::user();
        
        return SupportWorker::whereRaw("(`users`.`first_name` LIKE \"%".$query."%\" or `users`.`last_name` LIKE \"%".$query."%\" or `users`.`email` LIKE \"%".$query."%\")")
                            ->get();
    }


    private function getIdsFromResource($resourceSW){
        $_ids = [];
        foreach($resourceSW as $key => $obj){
            $_ids[] = $obj->user_id;
        }
        return $_ids;
    }


}
