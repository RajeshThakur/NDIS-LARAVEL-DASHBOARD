<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountsApiController extends Controller
{


    /**
     * Display a list of Completed Service Bookings Under Timesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function workerTimesheet()
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
    public function workerSubmissions()
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
    public function workerPayments()
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
    public function workerProda()
    {
        //
        $data = array();
        return view('admin.account.index', compact('data'));
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



    
}
