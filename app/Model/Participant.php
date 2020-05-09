<?php

namespace App;

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


    // protected $primaryKey = 'user_id';

    protected $appends = array('full_name');

    protected $hidden = [
        // 'ndis_number',
        'token',
        'user_id',
        'email_verified_at',
        'platform',
        "stripe_id",
        "card_brand",
        "card_last_four",
        "trial_ends_at",
        "created_at",
        "updated_at",
        "deleted_at",
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

        static::addGlobalScope(new ParticipantProviderScope);
    }
     //------------------------------------------------------------------------------------------------------
    // Relationships
    
    public function reg_groups()
    {
        return $this->hasMany(\App\ParticipantRegGroups::class, 'user_id', 'user_id');
    }

    /**
     * Get the particpant User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Bookings', 'user_id', 'user_id');
    }

    // Relationship with Availabilities
    public function availability()
    {
        return $this->hasMany('App\Availability', 'user_id', 'user_id');
    }

    /**
     * Relationship with Signatures
     */
    public function signature()
    {
        return $this->hasOne(\App\Signature::class, 'user_id', 'user_id');
    }

    // End of Relationships
    //------------------------------------------------------------------------------------------------------

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

    /**
     * Scope to get Participants only linked to Particular Support Worker / External Service
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForWorker($query, $supp_wrkr_ext_serv_id)
    {
        return $query->whereIn('participants_details.user_id', function($query) use($supp_wrkr_ext_serv_id) {
                                                                                $query->distinct()
                                                                                    ->select('participant_id')
                                                                                    ->from(with(new Bookings)->getTable())
                                                                                    ->where('supp_wrkr_ext_serv_id', $supp_wrkr_ext_serv_id);
                                                                            });
    }


    public function scopeSearch( $query, $q ){
        return $query->whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `users`.`email` like "%'.$q.'%")' );
    }


    public function getFullNameAttribute()
    {
        return $this->getName();  
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
     * Set Attributes
     */
    public function getStartDateNdisAttribute($value)
    {
        return DBToDate($value);
    }

    public function setStartDateNdisAttribute($value)
    {
        $this->attributes['start_date_ndis'] = dateToDB($value);
    }

    public function getEndDateNdisAttribute($value)
    {
        return DBToDate($value);
    }

    public function setEndDateNdisAttribute($value)
    {
        $this->attributes['end_date_ndis'] = dateToDB($value);
    }

    public function getAvatarAttribute($value)
    {
        return getDocumentUrl($value);
    }



    public function getName(){
        if(isset($this->first_name))
            return $this->first_name . ' ' . $this->last_name;
        else
            return '';
    }


    public static function providerParticipants( $q = "" )
    {
        $provider = \Auth::user();

        if($q != ""){
            return Participant::whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `users`.`email` like "%'.$q.'%")' )
                                ->get();
        }else{
            return Participant::get();
        }
        
    }


    public function getParticipant( $participantId ) 
    {
        $user = \Auth::user();
        return Participant::where('participants_details.user_id', $participantId)->first();
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
                            // ->where('users.active', 1)
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
                            ->where('provider_reg_groups.user_id', \Auth::user()->id)
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
                            ->where('provider_reg_groups.user_id', \Auth::user()->id)
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
            ->get();
    }

    /**
     * Search participantsby name or email
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchParticipants( $query ){

        $user = \Auth::user();
        
        return \App\Participant::whereRaw("(`users`.`first_name` LIKE \"%".$query."%\" or `users`.`last_name` LIKE \"%".$query."%\" or `users`.`email` LIKE \"%".$query."%\")")
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


    public static function basicInfo( $user_id ){
        $participant = Participant::where('participants_details.user_id', $user_id)
                                            ->select(
                                                'users.id',
                                                'users.first_name',
                                                'users.last_name',
                                                'users.email',
                                                'users.avatar'
                                            )
                                            ->first();
        return ($participant)?$participant->toArray():null;
    }


}
