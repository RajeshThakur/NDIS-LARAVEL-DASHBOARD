<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Task;
use App\Provider;
use App\RegistrationGroup;
use App\Bookings;
use Illuminate\Support\Facades\DB;
// use Notification;


class DashboardController extends Controller
{    

    public function index( Request $request)
    {
        // dd(\Artisan::call('clean:cache'),1);
        //after authentication redirect provider back to requested page
        $old_url = $request->session()->get('old_url');
        $request->session()->forget('old_url');
        if(isset($old_url)){
            return redirect($old_url);
        }

        $user = \Auth::user();
        $events = Task::whereNotNull('due_date')->whereNotIn('color_id', [0])->get();
        $onboarding = 0;

        global $tasks,$count;
        $count = 0;
        $events = $events->groupBy('due_date')->map(function ($item, $key) {
            global $tasks,$count;
            $temp = $item->toArray();
            if(sizeof($temp) > 1){
                foreach( $temp as $k=>$v ){
                    $temp[$k]['multi'] = 'multi' ;
                    $tasks[$count] = $temp[$k];
                    $count++;
                }
            }else{
                $temp[0]['multi'] = 'single';
                $tasks[$count] = $temp[0];
                $count++;
            }
            return $item;
        });
        $count = null;
        
        $events = json_decode(json_encode($tasks), FALSE);
        $events = collect($events);
        // pr($tasks,1);
        // pr($events,1);
        $tasks = null;

        $feedCount = array(
                            'overdues' => Task::overdues()->get()->count(),
                            'upcoming' => Bookings::futureBookingsCount(),
                            'incomplete' => Bookings::incompleteBookingsCount(),
                            // 'without' => \App\Participant::participantsWithoutBooking()->count()
                            'without' => Bookings::participantsWithoutBooking()->count()

                        );

        // pr($feedCount);
        
        if($user->roles()->get()->contains(1)){ //For Admin Role

            return view('admin.dashboard.home',compact('events','feedCount'));

        }
        else if( $user->roles()->get()->contains(2) ){
            
            //For Provider Role
            $onboarding = Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail();
            $onboarding = $onboarding->is_onboarding_complete;
            
            if( ! Cookie::get('onboarding-status') )
                Cookie::queue(Cookie::make('onboarding-status', $onboarding, '1440'));
            

            $isSkipped = Cookie::get('skipped-onboarding');

            if( $onboarding || isset($request->skipped) || isset($isSkipped) ) {
                
                Cookie::queue(Cookie::make('skipped-onboarding', '1', '1440'));
                
                return view('admin.dashboard.home',compact('events','feedCount'));

            }
            else{

                return view('admin.onboard');
            }        
            
        }
        else{
            abort(403,'You are not authorized.');
        }

    }


    public function onboard( Request $request)
    { 
        return redirect('/admin');
        return View::make("admin.onboard");

    }


    public function overdueTasks( Request $request)
    {         
        $overdues = Task::with('assignees')->overdues()->get();
        // pr($overdues->toArray(),1);
        if( $overdues->isEmpty() ){
            echo json_encode(array("msg"=>'<div class="no-data">'.trans('msg.tasks.no_task').'</div>','status'=>false));
        }
        else{
            ob_start();
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody> 
            <?php
            $overdues->map(function ($item, $key) {    
                $startDate = dbToDatetime( \Carbon\Carbon::create( $item['due_date'] ." ".$item['start_time'] ) );
                // $startDate = $startDate->toDayDateTimeString();

                $endDate = dbToDatetime(\Carbon\Carbon::create($item['due_date'] ." ".$item['end_time']));
                // $endDate = $endDate->toDayDateTimeString();
                
                $status = \App\TaskStatus::all()->pluck('name','id')->toArray();
                
                ?>
                        <tr>                            
                            <td><a class="icon" href="<?php echo route('admin.events.edit', [$item->id]) ?>"><?php echo $item->name;?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.events.edit', [$item->id]) ?>"><?php echo $startDate;?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.events.edit', [$item->id]) ?>"><?php echo $endDate;?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.events.edit', [$item->id]) ?>"><?php echo $status[$item->status_id];?></a></td>
                        </tr>
                    
                <?php                
            });  
            ?>
            </tbody>
                    </table>
                </div>
            </div>            
            <?php
            $html = ob_get_contents();
            ob_end_clean();    
            echo json_encode(array("msg"=>$html,'status'=>true));
        }      
        die();
    }

    public function upcomingParticipantBookings( Request $request)
    { 
        $upcomingPartcipantBookings = Bookings::futureBookings();
        // pr($upcomingPartcipantBookings->toArray(),1);
        if( $upcomingPartcipantBookings->isEmpty() ){
            echo json_encode(array("msg"=>'<div class="no-data">'.trans('msg.bookings.no_upcoming').'</div>','status'=>false));
        }
        else{
            ob_start();
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $upcomingPartcipantBookings->map(function ($item, $key) {
                                ?>
                                <tr>
                                    <td><a class="icon" href="<?php echo route('admin.bookings.edit', [$item->id]) ?>"><?php echo $item->participant_fname." ".$item->participant_lname;?></a></td>
                                    <td><a class="icon" href="<?php echo route('admin.bookings.edit', [$item->id]) ?>"><?php echo dbToDatetime($item->starts_at) ?></a></td>
                                    <td><a class="icon" href="<?php echo route('admin.bookings.edit', [$item->id]) ?>"><?php echo dbToDatetime($item->ends_at) ?></a></td>
                                    <td><a class="icon" href="<?php echo route('admin.bookings.edit', [$item->id]) ?>"><?php echo $item->status;?></a></td>
                                </tr>
                                <?php
                            });
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>            
            <?php
            $html = ob_get_contents();
            ob_end_clean();    
            echo json_encode(array("msg"=>$html,'status'=>true));
        }      
        die();
    }

    public function incompleteBookings( Request $request)
    { 
        // $incompleteBookings = Bookings::incompleteBookings();
        $incompleteBookings = Bookings::where('booking_orders.status','=',config('ndis.booking.statuses.NotSatisfied'))->get();
        // pr($incompleteBookings->toArray(),1);
        if( $incompleteBookings->isEmpty() ){
            echo json_encode(array("msg"=>'<div class="no-data">'.trans('msg.bookings.no_incomplete').'</div>','status'=>false));
        }
        else{
            ob_start();
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody> 
            <?php
            $incompleteBookings->map(function ($item, $key) {    
                $startDate = \Carbon\Carbon::createFromTimeString($item->starts_at);
                // $startDate = $startDate->toDayDateTimeString();

                $endDate = \Carbon\Carbon::createFromTimeString($item->ends_at);
                // $endDate = $endDate->toDayDateTimeString();

                // $status = \App\TaskStatus::all()->pluck('name','id')->toArray();
                
                ?>        
                              
                        <tr>                            
                            <td><a class="icon" href="<?php echo route('admin.bookings.manually-complete.show', [$item->id]) ?>"><?php echo $item->participant->first_name." ".$item->participant->last_name;?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.bookings.manually-complete.show', [$item->id]) ?>"><?php echo dbToDatetime( $item->starts_at ); ?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.bookings.manually-complete.show', [$item->id]) ?>"><?php echo dbToDatetime( $item->ends_at );?></a></td>
                            <td><a class="icon" href="<?php echo route('admin.bookings.manually-complete.show', [$item->id]) ?>"><?php echo trans('bookings.statuses.'.$item->status);?></a></td>
                        </tr>
                    
                <?php                
            });  
            ?>
            </tbody>
                    </table>
                </div>
            </div>            
            <?php
            $html = ob_get_contents();
            ob_end_clean();    
            echo json_encode(array("msg"=>$html,'status'=>true));
        }      
        die();
    }

    public function participantsWithoutBooking( Request $request)
    { 
        // $participantwobookings = \App\Participant::participantsWithoutBooking();
        $participantwobookings = Bookings::participantsWithoutBooking();
        // pr($participantwobookings,1);
        if( $participantwobookings->isEmpty() ){
            echo json_encode(array("msg"=>'<div class="no-data">'.trans('msg.bookings.no_without_booking').'</div>','status'=>false));
        }
        else{
            ob_start();
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Location</th>
                                <th>Mobile</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                    <tbody>
                <?php
                $participantwobookings->map(function ($item, $key) {
                    ?>
                    <tr>                            
                        <td><a class="icon" href="/admin/participants/<?php echo $item->id;?>/edit"><?php echo $item->first_name." ".$item->last_name;?></a></td>
                        <td><a class="icon" href="/admin/participants/<?php echo $item->id;?>/edit"><?php echo $item->address;?></a></td>
                        <td><a class="icon" href="/admin/participants/<?php echo $item->id;?>/edit"><?php echo $item->mobile;?></a></td>
                        <td><a class="icon" href="/admin/participants/<?php echo $item->id;?>/edit"><?php echo $item->email;?></a></td>
                    </tr>
                    <?php                
                });
            ?>
            </tbody>
                    </table>
                </div>
            </div> 
            <?php
            $html = ob_get_contents();
            ob_end_clean();    
            echo json_encode(array("msg"=>$html,'status'=>true));
        }   
        die();
    }

    
    public function updateEventDate( Request $request )
    {

        // pr($request->id);
        // pr($request->date,1);
        $status = Task::where('id', $request->id)
                        ->update(['due_date' => $request->date]);
        
        if($status){
            echo json_encode(array( 'status' => true, 'msg'=>""));
        }else{
            echo json_encode(array( 'status' => false, 'msg'=>""));
        }
        
        die();
    }

    public function notifications( Request $request ){

        $noifications = \Auth::user()->notifications()->orderBy('created_at','desc')->get();
        // dd($noifications);
        // pr($noifications, 1);
        // foreach ($noifications as $noification)
            // pr($noification->data, 1);

        return view('admin.notifications.all', compact('noifications'));
    }

    public function deletenotification($id) {
        $data = DB::table('notifications')->where('id',$id)->delete(); 
  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);   
    }


            
    /**
     * Dummy Admin view
     */
    public function testview()
    {
       return view('public.adminview');
    }

}
