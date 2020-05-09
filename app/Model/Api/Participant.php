<?php

namespace App\Model\Api;

use Hash;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


use Dmark\Bookings\Traits\HasBookings;
use App\Notifications\VerifyUserNotification;
use App\Guardian;

use App\Scopes\ParticipantProviderScope;



class Participant extends Model
{
    use Notifiable,SoftDeletes;

    public $table = 'participants_details';

    // protected $primaryKey = 'participants_details.user_id';
    protected $primaryKey = 'user_id';

    protected $hidden = [
        'ndis_number',
    ];

    protected $dates = [
        'end_date_ndis',
        'start_date_ndis'
    ];

    protected $fillable = [
        'lng',
        'lat',
        'address',
        'ndis_number',
        'end_date_ndis',
        'start_date_ndis',
        'participant_goals',
        'special_requirements',
        'budget_funding',
        'funds_balance',
        'using_guardian',
        'is_onboarding_complete',
    ];
    

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
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
        return $query->where('participants_details.is_onboarding_complete', 1)->where('participants_details.agreement_signed', 1);
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
        // return $this->belongsTo('App\User', 'user_id');
    }


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Model\Api\Bookings', 'participant_id');
    }

    // Relationship with Availabilities
    public function availability()
    {
        return $this->hasMany('App\Model\Api\Availability', 'user_id');
    }




    public function __update(){
        // DB::table('users')
        //             ->where('user_id', 1)
        //             ->update(['username' => $username, 'status' => $status]);
    }


    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function newQuery()
    // {
    //     return parent::newQuery();
    //     $query = parent::newQuery();
    //     dd($query);
    //     pr($query, 1);
    // }



    public static function providerParticipants( $q = "" )
    {
        $provider = \Auth::user();

        if($q != ""){
            return Participant::whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `users`.`email` like "%'.$q.'%")' )
                                ->select('participants_details.*','users.*')
                                ->get();

            // return Participant::where('users_to_providers.provider_id', $user->id)
            //                     ->where(function ($query) use ($q) {
            //                         $query->where('users.first_name', 'LIKE', '"%'.$q.'%"')
            //                                 ->orWhere('users.last_name', 'LIKE', '"%'.$q.'%"')
            //                                 ->orWhere('users.email', 'LIKE', '"%'.$q.'%"');
            //                     })
            //                     ->leftJoin('users', 'participants_details.user_id', '=', 'users.id')
            //                     ->leftJoin('users_to_providers', 'participants_details.user_id', '=', 'users_to_providers.user_id')
            //                     ->select('participants_details.*','users.*')->get();
            
        }else{
            return Participant::select('participants_details.*','users.*')->get();
        }
        
    }
   
    public function getParticipantUser( $participantId )
    {
        return Participant::where('participants_details.user_id', $participantId)
                    ->select('participants_details.*','users.*')->first();
    }

    
    


    public function getStartDateNdisAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateNdisAttribute($value)
    {
        $this->attributes['start_date_ndis'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateNdisAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateNdisAttribute($value)
    {
        $this->attributes['end_date_ndis'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function addParticipantGuardian( $email, $password){

        // pr($this, 1);
        $guardian = Guardian::create([
            'user_id' => $participant_id,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return $guardian;
    }

    

    //------------------------------------------------------
    //  Booking related functions
    //------------------------------------------------------

    public static function getBookableParticipants(){

        return Participant::where('participants_details.is_onboarding_complete', 1)
                            ->where('participants_details.agreement_signed', 1)
                            ->select('participants_details.*','users.*')
                            ->get();

    }

    /**
     * Function that returns the Registration Groups ( Parent only ) for the Current User instance
     * @return null injects the Registration Groups into current instance 
     */
    public function getParticipantRegGroups(){
        
        $reg_groups = [];
        $reg_groups[""] = "Please Select Registration Group";
        
        $regGroups = \App\RegistrationGroup::where('participants_reg_groups.user_id', $this->user_id )
                            ->where('participants_reg_groups.provider_id', \Auth::user()->id)
                            ->leftJoin('participants_reg_groups', 'participants_reg_groups.reg_group_id', '=', 'registration_groups.id')
                            ->select('registration_groups.title', 'registration_groups.id')
                            ->get();

        foreach($regGroups as $regGroup){
            $reg_groups[$regGroup->id] = $regGroup->title;
        }

        return $reg_groups;

    }

    public function getParticipantInhouseRegGroups(){
        
        $regGroups = \App\RegistrationGroup::where('participants_reg_groups.user_id', $this->user_id )
                            ->where('participants_reg_groups.provider_id', \Auth::user()->id)
                            ->where('provider_reg_groups.inhouse', '1')
                            ->leftJoin('participants_reg_groups', 'participants_reg_groups.reg_group_id', '=', 'registration_groups.id')
                            ->leftJoin('provider_reg_groups', 'participants_reg_groups.reg_group_id', '=', 'provider_reg_groups.parent_reg_group_id')
                            ->select('registration_groups.title', 'registration_groups.id')
                            ->groupBy('participants_reg_groups.reg_group_id')
                            ->get();
        // pr($regGroups, 1);
        if(!count($regGroups)){
            return [""=>"No In-house Registration Group Found"];
        }

        $reg_groups = [""=>"Please Select Registration Group"];
        foreach($regGroups as $regGroup){
            $reg_groups[$regGroup->id] = $regGroup->title;
        }
        return $reg_groups;
                    
    }

    public function getParticipantExternalRegGroups(){
        
        $regGroups = \App\RegistrationGroup::where('participants_reg_groups.user_id', $this->user_id )
                            ->where('participants_reg_groups.provider_id', \Auth::user()->id)
                            ->where('provider_reg_groups.inhouse', '<>', '1')
                            ->leftJoin('participants_reg_groups', 'participants_reg_groups.reg_group_id', '=', 'registration_groups.id')
                            ->leftJoin('provider_reg_groups', 'participants_reg_groups.reg_group_id', '=', 'provider_reg_groups.parent_reg_group_id')
                            ->select('registration_groups.title', 'registration_groups.id')
                            ->groupBy('participants_reg_groups.reg_group_id')
                            ->get();

        if(!count($regGroups)){
            return [""=>"No External Registration Group Found"];
        }
        $reg_groups = ["" => "Please Select Registration Group"];
        foreach($regGroups as $regGroup){
            $reg_groups[$regGroup->id] = $regGroup->title;
        }
        return $reg_groups;
                    
    }


    
    
    //------------------------------------------------------
    //  Check Participant availability
    public function getAvailabilityForRange($range){
        if(count($this->availability)){
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


    
    /**
     * Get list of Participants without bookings count
     *
     * @return interger
     */
    public static function participantsWithoutBookingCount(): int
    {
        $user = \Auth::user();

        $participants = \App\Participant::providerParticipants();

        $count = \App\Bookings::leftJoin('users','users.id','=','bookings.participant_id')                        
            ->where('booking_orders.status', '=', 'Cancelled')
            ->whereNotNull('canceled_at')
            ->select("count(`bookings`.id) as total")
            ->first();
        return ($count)?$count->total:0;
    }

    /**
     * Get list of Participants without bookings
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function participantsWithoutBooking(): Collection
    {
        $user = \Auth::user();

        
        return \App\Participant::ready()
            ->leftJoin('bookings','participants_details.user_id','<>','bookings.participant_id')
            ->leftJoin('booking_orders','bookings.id','=','booking_orders.booking_id')
            ->select( "users.*", "participants_details.*")
            ->get();
    }



    //------------------------------------------------------
    //  API functions
    //------------------------------------------------------
    public static function getParticipantforProvider( $user_id, $provider_id ){
        // return DB::table('users')->where('user_id', $user_id)->where('provider_id', $provider_id)->first();
        return Participant::withoutGlobalScope(ParticipantProviderScope::class)
                            ->where('users_to_providers.provider_id', $provider_id)->where('participants_details.user_id', $user_id)
                            ->leftJoin('users_to_providers', 'participants_details.user_id', '=', 'users_to_providers.user_id')
                            ->select('participants_details.*')->first();
    }







}
