<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Session;


class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $resuest)
    {
        $q = Input::get ( 'q' );
        $user = User::where('name','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->get();

        // return $user;
        if(count($user) > 0)
            return view('admin.search')->withDetails($user)->withQuery ( $q );
        else return view ('admin.search')->withMessage('No Details found. Try to search again !');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchByName(Request $request)
    {
        
        $searchType = $request->input('provider_agreement');        

        switch($searchType) {
            case 'participant':
                $q = ['q' => $request->input('keyword')];   
                return redirect()->route('admin.participants.index', $q);
                break;
            case 'supportworker':
                $q = ['s' => $request->input('keyword')];
                return redirect()->route('admin.support-workers.index', $q);
                break;
            case 'documentation' :
                $q = ['q' => $request->input('keyword')];   
                return redirect()->route('admin.forms.index', $q);
                break;
            default:
                dd('default');
                break;
        }

    }
}