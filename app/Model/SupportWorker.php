<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Symfony\Component\HttpFoundation\Request;
use App\User;
use App\Bookings;
use Carbon\Carbon;

use App\Scopes\SWProviderScope;

class SupportWorker extends Model
{

    use Notifiable,SoftDeletes;

    public $table = 'support_workers_details';

    public $timestamps = true;

    protected $hidden = [
        // 'password',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'lat',
        'lng',
        'email',
        'address',
        'is_onboarding_complete',
        'onboarding_step',
        'agreement_signed'
    ];


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SWProviderScope);
    }

    //-------------- Relationships ----------------------

    /**
     * Get the participants
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relationship with Availabilities
    public function availability()
    {
        return $this->hasMany('App\Availability', 'user_id', 'user_id');
    }


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Bookings', 'supp_wrkr_ext_serv_id', 'user_id');
    }

    // Relationship with Payouts
    public function payouts()
    {
        return $this->hasMany('App\Payout', 'user_id','user_id');
    }

    /**
     * Relationship with Signatures
     */
    public function signature()
    {
        return $this->hasOne(\App\Signature::class, 'user_id', 'user_id');
    }

    public function reg_grps()
    {
        return $this->hasMany( \App\UserRegGroup::class, 'user_id', 'user_id');
    }

    public function bookingOrder()
    {       
        return $this->hasManyThrough(
                                        'App\BookingOrders',
                                        'App\Bookings',
                                        'supp_wrkr_ext_serv_id',   // user id column in Bookings Table
                                        'booking_id',   // Local Key for BookingOrders Table
                                        'user_id', // Local Key for SupportWorker Table
                                        'id'   // Foreign Key in Bookings table
                                    );
    }

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

    /**
     * Scope to get Support Worker / External Service only linked to Particular Participant
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForParticpant($query, $participant_id)
    {
        return $query->whereIn('support_workers_details.user_id', function($query) use($participant_id) {
                                                                                $query->distinct()
                                                                                    ->select('supp_wrkr_ext_serv_id')
                                                                                    ->from(with(new Bookings)->getTable())
                                                                                    ->where('participant_id', $participant_id);
                                                                            });
    }

    public function scopeSearch( $query, $q ){
        return $query->whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `users`.`email` like "%'.$q.'%")' );
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
    

    

    public function getAvatarAttribute($value)
    {
        return getDocumentUrl($value);
    }

    


    public static function providerSupportWorkers(){
        $user = \Auth::user();
        // pr($user->id,1);
        return SupportWorker::select('support_workers_details.*','users.*')->get();
        
    }

    public function getName(){
        if(isset($this->first_name))
            return $this->first_name . ' ' . $this->last_name;
        else
            return '';
    }

    /**
     * Function to update the regGroups
     * @param $regGroups array of Reg Groups
     */
    public function updateRegGroups( $provider_id, $regGroups = [] ){
        // pr($this, 1);
        if($this->id){

            $newRegGroups = [];

            // first let's go through all Groups and delete which doesn't exists in $regGroups
            foreach($this->reg_grps as $existingGroup){
                if(!in_array( $existingGroup->reg_group_id, $regGroups )){
                    // $this->reg_grps->find($existingGroup->reg_group_id)->delete();
                    \App\UserRegGroup::where('reg_group_id',$existingGroup->reg_group_id)->where('user_id', $this->user_id)->delete();;
                }else{
                    if (( $key = array_search($existingGroup->reg_group_id, $regGroups)) !== false) {
                        unset($regGroups[$key]);
                    }
                }
            }

            //Add the New RegGroups
            foreach($regGroups as $regGroup){
                $newRegGroups[] =  new \App\UserRegGroup([
                    'reg_group_id' => $regGroup,
                    'user_id' =>  $this->user_id,
                    'provider_id' => $provider_id
                ]);
            }

            //Save reg Groups
            $this->reg_grps()->saveMany($newRegGroups);

        }
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
                                // ->leftJoin('users','users.id','=','bookings.participant_id')
                                // ->select(   'bookings.location as booking_location',
                                //             'bookings.id as booking_id',
                                //             'bookings.item_number as booking_item_number',
                                //             'booking_orders.starts_at as booking_start_date',
                                //             'booking_orders.ends_at as booking_end_date',
                                //             'bookings.service_type as booking_service_type',
                                //             'bookings.participant_id as booking_participant_id',
                                //             'bookings.supp_wrkr_ext_serv_id as booking_supp_wrkr_ext_serv_id', 
                                //             'users.id as participant_id',
                                //             'users.first_name as participant_fname',
                                //             'users.last_name as participant_lname',
                                //             'users.email as participant_email',
                                //             'users.mobile as participant_mobile'
                                //         )
                                // ->get();
                                ->Join('users','users.id','=','bookings.participant_id')
                                ->join('participants_details', 'participants_details.user_id', '=', 'users.id')
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
                                    'users.mobile as participant_mobile',
                                    'participants_details.id as participants_details_id'
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

    public function getSupportWorkerIdsByRegGroup( $regGrpId ){
       
        return $this->where('user_reg_groups.reg_group_id', $regGrpId)
                    ->where('users.active',  1)
                    ->leftJoin('user_reg_groups', 'support_workers_details.user_id', '=', 'user_reg_groups.user_id')
                    ->leftJoin('registration_groups', 'user_reg_groups.reg_group_id', '=', 'registration_groups.id')
                    ->leftJoin('provider_reg_groups', 'user_reg_groups.reg_group_id', '=', 'provider_reg_groups.parent_reg_group_id')
                    ->select('support_workers_details.user_id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name") )
                    ->groupBy('support_workers_details.user_id')
                    ->ready()
                    ->get();

    }

    public function filterSWbyAvailability( $resourceSW, $date, $start_time, $end_time ){
        $filterable_ids = $this->getIdsFromResource( $resourceSW );
        return $this->whereIn('support_workers_details.user_id', $filterable_ids)
                    ->select('support_workers_details.user_id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name") )
                    ->get();

    }

    public function filterSWbyLocation( $resourceSW, $lat, $lng ){
        
        // Way 1
        // $cities = City::select(DB::raw('*, ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
        //     ->having('distance', '<', 25)
        //     ->orderBy('distance')
        //     ->get();
        
            
        $filterable_ids = $this->getIdsFromResource( $resourceSW );

        $radius = 100; //in kms

        return $this->whereIn('support_workers_details.user_id', $filterable_ids)
                    ->having('distance', '<', $radius)
                    ->orderBy('distance')
                    ->select(
                                'support_workers_details.user_id',
                                DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"), 
                                DB::raw("( 6367 * acos( cos( radians({$lat}) ) * cos( radians( support_workers_details.lat ) ) * cos( radians( support_workers_details.lng ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( support_workers_details.lat ) ) ) ) AS distance") 
                            )
                    ->get();

    }

    //------------------------------------------------------
    //  Check Support Worker availability
    public function getAvailabilityForRange($range){
        if($this->availability){
            foreach($this->availability as $availability){
                if(strtolower($range) == \strtolower($availability->range)){
                    return $availability;
                }
            }
        }

        return false;
    }

    public function availableBetween( $starts_at, $ends_at ){

        $range = strtolower($starts_at->format('l'));

        $range_data = $this->getAvailabilityForRange($range);

        if(!$range_data)
            return false;

        $range_start = Carbon::parse( $starts_at->format( config('panel.date_format') ) . ' '. $range_data->from );
        $range_end = Carbon::parse( $ends_at->format( config('panel.date_format') ) . ' '. $range_data->to );

        if( $starts_at->lessThan($range_start) || $ends_at->greaterThan($range_end) )
            return false;
        
        return true;
    }


    //------------------------------------------------------
    //  API functions
    //------------------------------------------------------
    public static function basicInfo( $user_id ){
        $support_worker = SupportWorker::where('support_workers_details.user_id', $user_id)
                            ->select(
                                'users.id',
                                'users.first_name',
                                'users.last_name',
                                'users.email',
                                'users.avatar'
                            )
                            ->first();
        return ($support_worker)?$support_worker->toArray():null;
    }


    

}
