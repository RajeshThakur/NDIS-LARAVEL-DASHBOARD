<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use DB;

class AutocompleteController extends Controller
{
    //for create controller - php artisan make:controller AutocompleteController

    function index()
    {
        //
    }

    function fetch(Request $request)
    {
        if($request->get('query')){

            // pr(\Auth::id(),1);
            
            $query = $request->get('query');
        
            $data = DB::table('users')
                                      ->whereRaw("(`users`.`first_name` LIKE \"%".$query."%\" or `users`.`last_name` LIKE \"%".$query."%\" or `users`.`email` LIKE \"%".$query."%\")")  
                                      ->join('role_user', function ($join) {
                                                            $join->on('users.id', '=', 'role_user.user_id')
                                                                ->whereNotIn('role_user.role_id', ['1','2'])
                                                                ->whereIn ('role_user.role_id', ['3','4','5']);
                                                          })
                                      ->join('users_to_providers', function ($join) {
                                                            $join->on('users.id', '=', 'users_to_providers.user_id')
                                                                ->where('users_to_providers.provider_id', '=',\Auth::id());
                                                          })
                                      ->select('users.first_name','users.last_name', 'users.email', 'users.id')
                                    //   ->toSql();
                                      ->get();

            // dd($data);

            if( sizeof($data) > 0){
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach($data as $row)
                {
                    $output .= '
                    <li data-id="' . $row->id . '">' .$row->first_name .' '.$row->last_name. ' ('.$row->email.')</li>';
                }
                $output .= '</ul>';
                echo $output;
            }else{
                echo false;
            }

            die();

        
        }
    }

}
