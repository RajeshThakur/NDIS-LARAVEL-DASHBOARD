<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Traits\BookingTrait;

class BookingOrders extends Model
{
    use SoftDeletes, BookingTrait;

    public $table = 'booking_orders';

    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'booking_id',
        'starts_at',
        'ends_at',
        'timezone',
        'is_billable',
        'is_cancelled',
        'cancelled_at',
        'amount',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = ['booking','timesheet'];

    public function booking()
    {
        return $this->belongsTo(\App\Bookings::class);
    }

    public function checkin()
    {
        return $this->hasOne(\App\BookingCheckin::class,'booking_order_id', 'id');
    }
    
    public function checkout()
    {
        return $this->hasOne(\App\BookingCheckout::class,'booking_order_id', 'id');
    }

    public function message()
    {
        return $this->hasMany(\App\Model\Api\BookingMessages::class,'booking_order_id', 'id');
    }

    public function participant()
    { 
        return $this->hasOneThrough(
                                        'App\Participant',
                                        'App\Bookings',
                                        'id',   // Bookings Table ID
                                        'user_id',   // Local Key for Participant Table
                                        'booking_id',
                                        'participant_id'   // Foreign Key in Bookings table
                                    );
    }
    public function supportWorker()
    {       
        return $this->hasOneThrough(
                                        'App\SupportWorker',
                                        'App\Bookings',
                                        'id',   // Bookings Table ID
                                        'user_id',   // Local Key for SupportWorker Table
                                        'booking_id',
                                        'supp_wrkr_ext_serv_id'   // Foreign Key in Bookings table
                                    );
    }

    public function worker()
    {       
        return $this->hasOneThrough(
                                        'App\User',
                                        'App\Bookings',
                                        'id',   // Bookings Table ID
                                        'id',   // Local Key for User Table
                                        'booking_id',
                                        'supp_wrkr_ext_serv_id'   // Foreign Key in Bookings table
                                    );
    }

    public function timesheet()
    {
        return $this->hasOne(\App\Timesheet::class,'booking_order_id', 'id');
    }
    
    public function meta()
    {
        return $this->hasMany(\App\BookingOrderMeta::class,'booking_order_id', 'id');
    }

    public function incidents()
    {
        return $this->hasMany(\App\BookingIncidents::class, 'booking_order_id', 'id');
    }

    public function complaints()
    {
        return $this->hasMany(\App\BookingComplaints::class, 'booking_order_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(\App\Notes::class, 'relation_id', 'id')->where('notes.type', 'booking');
    }

    /**
     * Set Attributes
     */
    public function getStartsAtAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setStartsAtAttribute($value)
    {
        $this->attributes['starts_at'] = datetimeToDB($value);
    }
    
    public function getEndsAtAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setEndsAtAttribute($value)
    {
        $this->attributes['ends_at'] = datetimeToDB($value);
    }

    /**
     * Scope a query to fetch participant bookings for requested params
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ScopeSearchParticipantBookings($query, $request)
    {
        $query->leftJoin('bookings','booking_orders.booking_id','=','bookings.id');
        $query->leftJoin('participants_details','bookings.participant_id','=','participants_details.user_id');
        $query->leftJoin('users','participants_details.user_id','=','users.id');
        // dd($request->all());
        if( !empty($request->member) ):
            $query->where( 'users.first_name' , 'like', '%'.$request->member.'%')
                  ->orWhere( 'users.last_name' , 'like','%'.$request->member.'%')
                  ->orWhere( 'users.email' , 'like', '%'.$request->member.'%');
        endif;

        if( !empty($request->start_date) ):
            $query->whereDate( 'booking_orders.starts_at' , '>', Carbon::parse($request->start_date));
        endif; 

        if( !empty($request->end_date) ):
            $query->whereDate( 'booking_orders.starts_at' , '<', Carbon::parse($request->end_date));
        endif;

        if( !empty($request->status)):
            $query->where( 'status','like','%'.$request->status.'%' );
        endif;

        // pr($query->toSql(),1);

        return $query->get();
        
    }

    /**
     * Scope a query to fetch sw bookings for requested params
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ScopeSearchSWBookings($query, $request)
    {
        $query->leftJoin('bookings','booking_orders.booking_id','=','bookings.id');
        $query->leftJoin('support_workers_details','bookings.supp_wrkr_ext_serv_id','=','support_workers_details.user_id');
        $query->leftJoin('service_provider_details','bookings.supp_wrkr_ext_serv_id','=','service_provider_details.user_id');
        $query->leftJoin('users','support_workers_details.user_id','=','users.id');
        // dd($request->all());
        if( !empty($request->member) ):
            $query->where( 'users.first_name' , 'like', '%'.$request->member.'%')
                  ->orWhere( 'users.last_name' , 'like','%'.$request->member.'%')
                  ->orWhere( 'users.email' , 'like', '%'.$request->member.'%');
        endif;

        if( !empty($request->start_date) ):
            $query->whereDate( 'booking_orders.starts_at' , '>', Carbon::parse($request->start_date));
        endif;

        if( !empty($request->end_date) ):
            $query->whereDate( 'booking_orders.starts_at' , '<', Carbon::parse($request->end_date));
        endif;

        if( !empty($request->status)):
            $query->where( 'status','like','%'.$request->status.'%' );
        endif;

        // pr($query->toSql(),1);
        return $query->get();
    }


}
