<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\BookingOrders;

class ApiBookingVerify
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = \Auth::user();
        
        if($request->getMethod() == 'GET'){
            $request->request->add([
                'booking_order_id'=>$request->route('booking_order_id')
            ]);
        }
        
        $data = Validator::make( $request->all(), [
            'booking_order_id'   => 'required | integer',
        ], [
            'booking_order_id.required'   => "Booking instance ID is required!",
            'booking_order_id.integer'   => "Booking instance ID is invalid!"
        ]);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;  

        //Check if User is valid for the booking_order_id and if participant /  Support Worker
        // $bookingOrder = BookingOrders::with(['booking','checkin'])
        //         ->whereIn('booking_orders.status', [ config('ndis.booking.statuses.Scheduled'), config('ndis.booking.statuses.Started') ] )
        //         ->where('booking_orders.id', $request->input('booking_order_id') )
        //         ->first();

        $bookingOrder = BookingOrders::where('booking_orders.id', $request->input('booking_order_id') )->first();

        if(!$bookingOrder)
            return apiError("Invalid booking!", 404);

        //Check if Booking service_type is support_worker
        if($bookingOrder->booking->service_type != 'support_worker')
            return apiError('Only InHouse Bookings are supported on App!', 403);

        //If given User is not a part of the Booking return error
        if( ! in_array( $user->id, [ $bookingOrder->booking->participant_id, $bookingOrder->booking->supp_wrkr_ext_serv_id ] ) )
            return apiError('Not a valid member for booking!', 401);

        
        $request->merge(['bookingOrder' => $bookingOrder]);

        return $next($request);
    }
}
