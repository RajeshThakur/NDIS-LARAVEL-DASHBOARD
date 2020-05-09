<?php

namespace App\Model\Api;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;


use App\Http\Controllers\Traits\BookingTrait;

use App\Scopes\BookingsScope;

class Bookings extends Model
{
    use BookingTrait,Notifiable;

    public $timestamps = false;

    public $table = 'bookings';

    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    protected $fillable = [
        'location',
        'lat',
        'lng',
        'item_number',
        'service_type',
        'is_recurring',
        'recurring_frequency',
        'recurring_num',
        'provider_id',
        'participant_id',
        'supp_wrkr_ext_serv_id'
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

    //------------------------------------------------------------------------------------------------------
    // Relationships
    
    public function orders()
    {
        return $this->hasMany(\App\Model\Api\BookingOrders::class,'booking_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(\App\Model\Api\Participant::class, 'participant_id');
    }

    public function supportWorker()
    {
        return $this->belongsTo(\App\Model\Api\SupportWorker::class, 'supp_wrkr_ext_serv_id', 'user_id');
    }

    public function registration_group()
    {
        return $this->belongsTo(\App\Model\Api\RegistrationGroup::class, 'item_number');
    }

    public function notes()
    {
        return $this->hasMany(\App\Model\Api\Notes::class, 'relation_id', 'id')->where('notes.type', 'booking');
    }

    public function incident()
    {
        return $this->hasOne(\App\Model\Api\BookingIncidents::class, 'booking_id', 'id');
    }

    // End of Relationships
    //------------------------------------------------------------------------------------------------------
    

     /**
     * Scope a query to fetch bookings for requested query by sw/extwrker
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchBookings($query, $request)
    {

        if( !empty( $request->query('start_date') ) && !empty( $request->query('end_date') ) ){
            // $start = \DateTime::createFromFormat('Y-m-d', $request->query('start_date'));
            // $end = \DateTime::createFromFormat('Y-m-d', $request->query('end_date'));
            $query->whereDate('booking_orders.starts_at', '>=', $request->get('start_date'));
            $query->whereDate('booking_orders.ends_at', '<=', $request->get('end_date'));
        }elseif( !empty( $request->query('start_date') ) ){
            // $query->whereBetween('booking_orders.starts_at', [ $request->query('start_date'), $request->query('end_date')]);
            $query->whereDate('booking_orders.starts_at', $request->get('start_date'));
        }
        elseif( !empty( $request->query('end_date') ) ){
            $query->whereDate('booking_orders.ends_at', $request->get('end_date'));
        }


        if( !empty( $request->query('member') ) ){
            $query->join('users as participant', 'bookings.participant_id', '=', 'participant.id');
            $query->join('users as worker', 'bookings.supp_wrkr_ext_serv_id', '=', 'worker.id');
            $query->WhereRaw( "concat(participant.first_name,' ', participant.last_name) like '%".$request->query('member')."%'" );
            $query->orWhereRaw( "concat(worker.first_name,' ', worker.last_name) like '%".$request->query('member')."%'" );
        }

        // $query->groupBy('bookings.id');
        
        return $query->get();
        
    }

    /**
     * Scope a query to fetch bookings for requested query by participant
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ScopeSearchParticipantBookings($query, $request)
    {
        // return $query::all();

        $user = \Auth::user();
        // pr($request->all(),1);
        $members =   DB::table('users')
                        ->where('first_name', 'like',$request->input('member'))
                        ->orWhere('last_name', 'like',$request->input('member'))
                        ->orWhere('email', 'like',$request->input('member'))
                        ->select('id')
                        ->get();

                        // pr($members->pluck('id')->toArray());

        return $query->whereDate('booking_orders.starts_at', '>=', $request->get('start_date'))
                    ->whereDate('booking_orders.ends_at', '<=', $request->get('end_date'))
                    ->where('provider_id', '=', $user->id)
                    ->where(function ($query) use ($members){
                        $query->whereIn('participant_id', $members->pluck('id')->toArray());
                    })                   
                    ->get();

        
    }

    
    // End of Scopes
    //------------------------------------------------------------------------------------------------------

    
    public static function getNearBySupportworkers()
    {
        $user = \Auth::user();

        $sw = new \App\SupportWorker();

        return $sw->leftJoin('users', 'support_workers_details.user_id', '=', 'users.id')
                  ->select('users.email','users.id')
                  ->get();

    }


    public static function participantsRegGroups($pid){
        $user = \Auth::user();

        // pr($user->id);
        // pr($pid);

        return DB::table('participants_reg_groups')
                    ->where( [ ['provider_id', '=' ,$user->id], [ 'user_id', '=' ,$pid ] ] )
                    ->get();
    }



    

    


 
}   
