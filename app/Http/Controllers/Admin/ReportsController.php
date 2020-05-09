<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Bookings;
use App\BookingOrders;
use App\SupportWorker;
use App\Participant;
use App\ServiceProvider;

class ReportsController extends Controller
{
    
    public function __construct()
    {
        // then execute the parent constructor anyway
        parent::__construct();
        
    }

    public function index( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        return view('admin.reports.index');
        
    }

    /* Service Bookings within a specified time period */
    public function bookingsByTimeperiod( Request $request)
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        // dd($request->all());
        if( !empty( $request->input('member') ) || !empty( $request->input('start_date') ) || !empty( $request->input('end_date') ) ){
            
            // $v = $request->validate([
                // 'start_date' => 'bail|required| date',
                // 'end_date' => 'bail|required| date',
                // 'member' => 'bail|required| string',
            // ]);
            
            $bookings = Bookings::with('participant')->searchbookings($request);
            // pr( $bookings->toArray(),1 );
           
        }else{
            $bookings = Bookings::with('participant')->orderBy('starts_at', 'ASC')->get();
            // dd($bookings);
        }
        // $allParticipants = [];  
      
        // foreach( $bookings as $key=>$booking ){      
        //     $allParticipants[$booking->participant->id] = $booking->participant->first_name . $booking->participant->last_name;
          
        // }
        // dd($allParticipants);
       
        return view('admin.reports.bookings-by-time',compact('bookings'));
        
    }

    
    /* report of all  Participants */
    public function participants( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

         if( !empty( $request->input('member') ) ){
            
            $v = $request->validate([
                'member' => 'bail|required| string',
            ]);
            $participants = Participant::searchParticipants($request);
           
        }else{
            $participants = Participant::all();
        }

        $participants->load('reg_groups');
        // pr($participants->toArray(),1);
        return view('admin.reports.participants',compact('participants'));
        
    }


    /*  report for Service Bookings for Participants */
    public function participantsBookings( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        if( !empty( $request->input('member') ) || !empty( $request->input('start_date') ) || !empty( $request->input('end_date') ) || !empty( $request->input('status') ) ){
            
            // $v = $request->validate([
            //     'start_date' => 'bail|required| date',
            //     'end_date' => 'bail|required| date',
            //     'member' => 'bail|required| string',
            //     'status' => 'bail|required| string',
            // ]);
            $bookings = BookingOrders::searchparticipantbookings($request);
           
           
        }else{
            $bookings = BookingOrders::all();
        }

        $bookings->load('participant');
        $bookings->load('booking');
        $bookings->load('timesheet');

        // pr( $bookings->toArray(),1 );

        return view('admin.reports.participant-bookings',compact('bookings'));
        
    }

    /* report for Service Bookings for funding reports for the Participant */
    public function serviceBookingFundings( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        if( !empty( $request->input('member') ) ){

            $v = $request->validate([
                'member' => 'bail|required| string',
            ]);

            $booking_orders = BookingOrders::searchparticipantbookings($request);

        }else{

            $booking_orders = BookingOrders::all();
           
        }
        $booking_orders->load('participant');
        $booking_orders->load('booking');
        $booking_orders->load('timesheet');
        // pr($booking_orders,1);

        return view('admin.reports.service-booking-funding', compact('booking_orders'));
        
    }

    /* report of all Support Workers */
    public function supportWorkers( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        $bookings = Bookings::all();

        return view('admin.reports.support-workers',compact('bookings'));
        
    }
    

    /* report for Service Bookings for Support Workers */
    public function supportWorkersBookings( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);

        if( !empty( $request->input('member') ) || !empty( $request->input('start_date') ) || !empty( $request->input('end_date') ) || !empty( $request->input('status') ) ){
            
            // $v = $request->validate([
            //     'start_date' => 'bail|required| date',
            //     'end_date' => 'bail|required| date',
            //     'member' => 'bail|required| string',
            //     'status' => 'bail|required| string',
            // ]);
            $booking_orders = BookingOrders::searchswbookings($request);
           
        }else{
            $booking_orders = BookingOrders::all();
        }
        
        $booking_orders->load('worker');
        $booking_orders->load('booking');
        $booking_orders->load('timesheet');

        // dd($booking_orders->toArray());

        return view('admin.reports.support-worker-bookings', compact('booking_orders'));
        
    }

    /* report of all Service Workers */
    public function serviceWorkers( Request $request )
    {
        abort_unless(\Gate::allows('reports_access'), 403);


        if( !empty( $request->input('member') ) ){
            
            $v = $request->validate([
                'member' => 'bail|required| string',
            ]);
            $externals = ServiceProvider::searchexternals($request);
           
        }else{
            $externals = ServiceProvider::all();
        }

        $externals->load('reg_grps');

        // pr($externals,1);

        return view('admin.reports.service-workers',compact('externals'));
        
    }
}
