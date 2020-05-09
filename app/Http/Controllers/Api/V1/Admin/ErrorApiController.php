<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorApiController extends Controller
{
    public function fallback(){
        return response()->json([ 'status'=>false, 'message' => 'Not a valid request'], 404);
    }
}
