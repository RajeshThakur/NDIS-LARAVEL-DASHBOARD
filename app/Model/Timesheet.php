<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Api\BookingOrders;
use Illuminate\Support\Facades\DB;

class Timesheet extends Model
{
    public $table = 'timesheet';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'travel_compensation' => 'array'
    ];
    
    protected $fillable = [
        'booking_order_id',
        'total_time',
        'travel_compensation',
        'total_amount',
        'payable_amount',
        'is_billed',
        'submitted_on',
        'status'
    ];

    protected $with = ['payouts'];

      /**
     * Relationship with PRODA
     */
    public function proda()
    {
        return $this->belongsTo(Proda::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\BookingOrders::class,'id', 'booking_order_id');
    }

    /**
     * Relationship with Payouts
     */
    public function payouts()
    {
        return $this->hasOne( Payout::class, 'timesheet_id', 'id');
    }

    /**
     * Set Attributes
     */
    public function getSubmittedOnAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function setSubmittedOnAttribute($value)
    {
        $this->attributes['submitted_on'] = datetimeToDB($value);
    }


    public function updateBookingOrderStatus($timeSheetIs, $status)
    {

        if($status == 'Paid'){
            //take the timesheet records which is now paid and records update to payouts table
            $time_rec = $this->whereIn('id', $timeSheetIs)->get();
            
            foreach($time_rec as $key=>$value) {
                
                $user_id = $this->getSuppWorkrExtServId($value->booking_order_id);

                if($user_id){
                    
                    Payout::create([
                        'user_id' => $user_id,
                        'timesheet_id' => $value['id'],
                        // 'travel_compensation_amount' => $value['travel_compensation']['amount'],
                        // 'total_amount' => $value['total_amount'],
                        'status' => 1
                    ]);
                }else{
                    return 0;
                }
                
                
            }
            
        }
        
        //update the booking orders status to paid
        foreach($timeSheetIs as $id)
        {
            $bookObj = $this->where('id',$id)->first();

            DB::table('booking_orders')->where('id', $bookObj->booking_order_id)->update(['status' => $status]);
            
        }
        
    }

    public function updateParticipantFund($participant_id, $timesheet_id) 
    {

        $timesheet_total_amount = $this->where('id', $timesheet_id)->pluck('total_amount')->first();

        $participant = new \App\Participant;
        $parti = $participant->getParticipant($participant_id);

        $participant_total_fund = $parti->funds_balance;
        $participant_balance_fund = $participant_total_fund - $total_amount; 

        $parti->update(['funds_balance' => $participant_balance_fund]);
        
    }

    public function getSuppWorkrExtServId($supprtOrExtServId)
    {
        $data = DB::table('booking_orders')
                                    ->select('bookings.supp_wrkr_ext_serv_id')
                                    ->leftJoin('bookings', 'booking_orders.booking_id', '=', 'bookings.id')
                                    ->where('booking_orders.id', $supprtOrExtServId)
                                    ->get();
        return $data['0']->supp_wrkr_ext_serv_id;
    }
}
