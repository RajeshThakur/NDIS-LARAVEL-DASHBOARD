<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Role;

class NotificationsApiController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return $roles;
    }

    public function getAll()
    {
        $roles = Role::all();

        return $roles;
    }

}
