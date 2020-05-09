<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\Traits\BookingTrait;


use App\Scopes\BookingsScope;

class Bookings extends Model
{
    use BookingTrait, Notifiable;

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
        static::addGlobalScope(new BookingsScope);
    }
    

    //------------------------------------------------------------------------------------------------------
    // Relationships
    
    public function orders()
    {
        return $this->hasMany(\App\BookingOrders::class,'booking_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(\App\Participant::class, 'participant_id', 'user_id');
    }

    public function supportWorker()
    {
        return $this->belongsTo(\App\SupportWorker::class, 'supp_wrkr_ext_serv_id', 'user_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(\App\ServiceProvider::class, 'supp_wrkr_ext_serv_id', 'user_id');
    }

    public function registration_group()
    {
        return $this->belongsTo(\App\RegistrationGroup::class, 'item_number', 'id');
    }

    public function incident()
    {
        return $this->hasOneThrough(
                                        'App\BookingIncidents', 
                                        'App\BookingOrders',
                                        'booking_id',   // foreign Key in BookingOrders for Current Model
                                        'booking_order_id',   // foreign Key for Incident Table in middle model
                                        'id',    // Local Key in BookingOrders
                                        'id'   // Local Key in Current Model
                                    );
    }

    /**
     * Get the booking Support Worker
     */
    public function notes()
    {
        return $this->hasManyThrough(
                            'App\Notes',
                            'App\BookingOrders',
                            'booking_id', // Foreign key on bookings table...
                            'relation_id', // Foreign key on Participant table...
                            'id', // Local key on BookingOrders table...
                            'id' // Local key on bookings table...
        );
    }


    // End of Relationships
    //------------------------------------------------------------------------------------------------------


    

    //------------------------------------------------------------------------------------------------------
    // Scopes
    
    
    

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
            $to = dateToDB($request->start_date);
            $from = dateToDB($request->end_date);
            $query->whereDate('booking_orders.starts_at', '>=', $to);
            $query->whereDate('booking_orders.ends_at', '<=', $from);

            //$query->whereBetween('booking_orders.starts_at', [$request->get('start_date'), $request->get('end_date')]);
            //$query->whereBetween('booking_orders.ends_at', [$request->get('start_date'), $request->get('end_date')]);
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
            $query->orWhereRaw( "concat(worker.first_name, ' ', worker.last_name) like '%".$request->query('member')."%'" );
                
        }
        
        $query->where('booking_orders.status', '=', config('ndis.booking.statuses.Scheduled'));
        // dd($query->toSql());
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


    /**
     * 
     * Scope a query to include  participant without bookings under current provider
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipantsWithoutBooking($query)
    {
        $user = \Auth::user();

        $participants = \App\Participant::providerParticipants();

        $result = array(); 

        foreach ($participants as $key=>$p) {

            $current = $this->where( 'bookings.participant_id','=',$p->id)
                            ->leftJoin('users','users.id','=','bookings.participant_id')
                            ->whereDate('booking_orders.starts_at','>=',\Carbon\Carbon::now()->addWeek()->toDateTimeString())
                            ->select(
                                "bookings.*",
                                "booking_orders.starts_at as start_date",
                                "booking_orders.ends_at as end_date",
                                "booking_orders.status as status",
                                "users.first_name as participant_fname",
                                "users.last_name as participant_lname",
                                "users.mobile as participant_mobile",
                                "users.email as participant_email"
                            )
                            ->get()
                            ->toArray();
            if( sizeof($current) < 1 ):
                array_push($result,$p);
            endif;
            // pr($current);
        }
        
       
        return collect($result);
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

    


    //------------------------------------------------------------------------------------------------------
    // API Functions 

    /**
     * Scope for API to fetch bookings Orders joins
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserBookings($query)
    {
        if( \Auth::user()->roles()->get()->contains(3) )
            return $query->where('bookings.participant_id', \Auth::id());
        
        if( \Auth::user()->roles()->get()->contains(4) )
            return $query->where('bookings.supp_wrkr_ext_serv_id', \Auth::id());

        return $query;
    }
   


 
}   
