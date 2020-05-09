<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use App\Scopes\ServiceProviderScope;

class ServiceProvider extends Model
{

    protected $hidden = [
        'password',
    ];

    public $table = 'service_provider_details';

    protected $fillable = [
        'user_id',
        'address',
        'lat',
        'lng',
        'agreement_signed',
        'service_provided',
    ];

    protected $primaryKey = "user_id";


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ServiceProviderScope);
    }


    // Relationship with Service Bookings
    public function bookings()
    {
        return $this->hasMany('App\Bookings', 'supp_wrkr_ext_serv_id', 'user_id');
    }

    public function bookingOrder()
    {
        return $this->hasManyThrough(
                                        'App\BookingOrders',
                                        'App\Bookings',
                                        'supp_wrkr_ext_serv_id',   // user   id column in Bookings Table
                                        'booking_id',   // Local Key for BookingOrders Table
                                        'user_id', // Local Key for SupportWorker Table
                                        'id'   // Foreign Key in Bookings table
                                    );
    }

    public function reg_grps()
    {
        return $this->hasMany( \App\UserRegGroup::class, 'user_id', 'user_id');
    }

   
    /**
     * Get the participants
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }




    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReady($query)
    {
        return $query->where('service_provider_details.agreement_signed', 1);
    }

    /**
     * Search external by name or email
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function ScopeSearchExternals( $query, $request  ){

        $query->where( 'users.first_name' , 'like', '%'.$request->member.'%')
                ->orWhere( 'users.last_name' , 'like','%'.$request->member.'%')
                ->orWhere( 'users.email' , 'like', '%'.$request->member.'%');
        return $query->get();
    }

    /**
     * Scope to get External Service only linked to Particular Participant
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForParticpant($query, $participant_id)
    {
        return $query->whereIn('service_provider_details.user_id', function($query) use($participant_id) {
                                                                                $query->distinct()
                                                                                    ->select('supp_wrkr_ext_serv_id')
                                                                                    ->from(with(new Bookings)->getTable())
                                                                                    ->where('participant_id', $participant_id);
                                                                            });
    }

    public function scopeSearch( $query, $q ){
        return $query->whereRaw( '(`users`.`first_name` like "%'.$q.'%" or `users`.`last_name` like "%'.$q.'%" or `users`.`email` like "%'.$q.'%")' )->get();
    }

    /**
     * Function to update the regGroups
     * @param $regGroups array of Reg Groups
     */
    public function updateRegGroups( $regGroups = [] ){
        if($this->user_id){
            $provider = \Auth::user();
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
                    'provider_id' => $provider->id
                ]);
            }

            //Save reg Groups
            $this->reg_grps()->saveMany($newRegGroups);

        }
    }

    public function getServiceProvider( $swID ) 
    {
        $user = \Auth::user();
        return ServiceProvider::where('service_provider_details.user_id', $swID)
                    ->select('service_provider_details.*','users.*')->first();
    }

    public function getName()
    {
        if(isset($this->first_name))
            return $this->first_name . ' ' . $this->last_name;
        else
            return '';
    }


    public function getServiceProviderIdsByRegGroup( $regGrpId ){
       
        return $this->where('user_reg_groups.reg_group_id', $regGrpId)
                    ->leftJoin('user_reg_groups', 'service_provider_details.user_id', '=', 'user_reg_groups.user_id')
                    ->leftJoin('registration_groups', 'user_reg_groups.reg_group_id', '=', 'registration_groups.id')
                    ->leftJoin('provider_reg_groups', 'user_reg_groups.reg_group_id', '=', 'provider_reg_groups.parent_reg_group_id')
                    ->select('service_provider_details.user_id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name") )
                    ->groupBy('service_provider_details.user_id')
                    ->ready()
                    ->get();

    }

    //------------------------------------------------------
    //  API functions
    //------------------------------------------------------
    public static function basicInfo( $user_id ){
        $support_worker = ServiceProvider::where('service_provider_details.user_id', $user_id)
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
