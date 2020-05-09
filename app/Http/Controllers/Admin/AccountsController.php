<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Timesheet;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Proda;
use App\BookingOrders;
use App\Accounts;
class AccountsController extends Controller
{


    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function workerTimesheet($name='null')
    {
        
        $status = config('ndis.booking.statuses.Approved');

        if($name == 'external'){
            $type = 'external';
            $service_type = 'external_service';
        } else {
            $type = 'support';
            $service_type = 'support_worker';
        }

        $is_billed = 0;

        $account = new Accounts();

        $records = $account->get_timesheet_records($status, $service_type, $is_billed);
        
        // pr($records,1);
        foreach($records as $record) {
            $record->participant_name = $this->participantName($record->participant_id);
            $record->supp_wrkr_ext_name = $this->suppWrkrOrExtWrkrName($record->supp_wrkr_ext_serv_id);
        }        
        
        $activeTabInfo = [ 'tab'=>'timesheet', 'file'=>"admin.account.timesheet_list", "title" => 'Time Sheet' ];

        $link['href_link'] = 'admin.accounts.timesheet_update';
        
        return view('admin.account.index', compact('records','activeTabInfo','link','type'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function workerSubmissions($name='null')
    {
        $status = config('ndis.booking.statuses.Submitted');

        if($name == 'external'){
            $type = 'external';
            $service_type = 'external_service';
        } else {
            $type = 'support';
            $service_type = 'support_worker';
        }

        $is_billed = 1;

        $account = new Accounts();

        $records = $account->get_timesheet_records($status, $service_type, $is_billed);

        foreach($records as $record) {
            $record->participant_name = $this->participantName($record->participant_id);
            $record->supp_wrkr_ext_name = $this->suppWrkrOrExtWrkrName($record->supp_wrkr_ext_serv_id);
        }
        
        $activeTabInfo = [ 'tab'=>'submissions', 'file'=>"admin.account.submissions_list", "title" => 'Submissions' ];

        $link['href_link'] = 'admin.accounts.submission_update';

        return view('admin.account.index', compact('records','activeTabInfo','link','type'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function workerPayments($name='null')
    {
        //
        $status = 'Paid';

        if($name == 'external'){
            $type = 'external';
            $service_type = 'external_service';
        } else {
            $type = 'support';
            $service_type = 'support_worker';
        }

        $is_billed = 1;

        $account = new Accounts();

        $records = $account->get_timesheet_records($status, $service_type, $is_billed);

        foreach($records as $record) {
            $record->participant_name = $this->participantName($record->participant_id);
            $record->supp_wrkr_ext_name = $this->suppWrkrOrExtWrkrName($record->supp_wrkr_ext_serv_id);
        }

        $activeTabInfo = [ 'tab'=>'payments', 'file'=>"admin.account.payments_list", "title" => 'Payment List' ];

        return view('admin.account.index', compact('records','activeTabInfo','type'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function workerProda($name='null')
    {
        
        if($name == 'external'){
            $type = 'external';
            $service_type = 'external_service';
        } else {
            $type = 'support';
            $service_type = 'support_worker';
        }
        
        $proda = new Proda();

        $records = $proda->getProdaRecords($service_type);
        

        $activeTabInfo = [ 'tab'=>'proda', 'file'=>"admin.account.proda_list", "title" => 'Proda List' ];

        return view('admin.account.index', compact('records','activeTabInfo','type'));

    }



    //------------------------------------------------------------------------------------------------------
    //------------------------------------- External Service Provider --------------------------------------
    //------------------------------------------------------------------------------------------------------

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function externalTimesheet()
    {
        //
        $data = array();
        return view('admin.account.index', compact('data'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function externalSubmissions()
    {
        //
        $data = array();
        return view('admin.account.index', compact('data'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function externalPayments()
    {
        //
        $data = array();
        return view('admin.account.index', compact('data'));
    }

    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function externalProda()
    {
        //
        $data = array();
        return view('admin.account.index', compact('data'));
    }

    public function workerTimesheet_update( Request $request, $name='null' )
    {
        $messages = [
            'paid'   => "Select the checkbox for which records to be submitted.",
        ];

        $data = Validator::make( $request->all(), [
                            'paid' => 'required|array'
                            ], $messages);

        if($data->fails()):
            return redirect()->back()->withErrors($messages);
        endif;

        $timeSheetId = $request->input('paid');

        $status = 'Submitted';

        $timesheet = new Timesheet();

        $timesheet->whereIn('id', $timeSheetId)->update(['is_billed' => 1, 'submitted_on' => \Carbon\Carbon::now()]);
        
        $timesheet->updateBookingOrderStatus($timeSheetId, $status);

        $prodaRec = new Proda();

        $prodaRec->title = time().'_proda';

        $prodaRec->save();

        $prodaRec->timesheet()->sync($timeSheetId);

        return redirect()->route('admin.accounts.timesheet', $name);
        
    }

    public function workerSubmission_update( Request $request, $name='null' )
    {

        $messages = [
            'paid'   => "Select the checkbox for which records to be paid.",
        ];

        $data = Validator::make( $request->all(), [
                            'paid' => 'required|array'
                            ], $messages);

        if($data->fails()):
            return redirect()->back()->withErrors($messages);
        endif;
        

        $partcipantsIds = $request->input('participant_id');
        
        $timeSheetId = $request->input('paid');

        $status = 'Paid';

        $timesheet = new Timesheet();

        //update the participant fund balances
        // foreach($request->input('paid') as $key=>$value){
        //     $timesheet->updateParticipantFund($partcipantsIds[$key], $value);
        // }
        
        //update booking status
        $timesheet->updateBookingOrderStatus($timeSheetId, $status);

        return redirect()->route('admin.accounts.submission', $name);
        
    }

    public function getProdaTimesheet($id, $name='null')
    {

        if($name == 'external'){
            $type = 'external';
            $service_type = 'external_service';
        } else {
            $type = 'support';
            $service_type = 'support_worker';
        }

        $prodaObj = new Proda();

        $prdaObj = $prodaObj->where('id',$id)->with('timesheet')->first();
        
        $timeSheet = $prdaObj->timesheet;

        foreach($timeSheet as $sheet){
            
            $participant_id = $prodaObj->get_Participant_id($sheet->booking_order_id, $service_type);

            $participant_name = $this->participantName($participant_id);

            $sheet['participant_name'] = $participant_name;
            
            //dump($sheet->booking_order_id);
        }

        $activeTabInfo = [ 'tab'=>'proda', 'file'=>"admin.account.proda_with_timesheet", "title" => 'Proda Detail' ];
        
        return view('admin.account.index', compact('timeSheet','activeTabInfo','type'));

        
    }

    public function participantName($id)
    {
        if($id) {

            $name = User::where('id', $id)->first();
            return $name->first_name.' '.$name->last_name;

        } else {
            return 'No name';
        }

    }

    public function suppWrkrOrExtWrkrName($id)
    {
        if($id) {

            $name = User::where('id', $id)->first();

            return $name->first_name.' '.$name->last_name;

        } else {
            return 'No name';
        }
    }

    
}
