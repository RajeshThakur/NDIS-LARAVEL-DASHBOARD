<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistrationGroupRequest;
use App\Http\Requests\UpdateRegistrationGroupRequest;
use App\RegistrationGroup;

class RegistrationGroupsApiController extends Controller
{
    public function index()
    {
        $registrationGroups = RegistrationGroup::all();

        return $registrationGroups;
    }

    public function store(StoreRegistrationGroupRequest $request)
    {
        return RegistrationGroup::create($request->all());
    }

    public function update(UpdateRegistrationGroupRequest $request, RegistrationGroup $registrationGroup)
    {
        return $registrationGroup->update($request->all());
    }

    public function show(RegistrationGroup $registrationGroup)
    {
        return $registrationGroup;
    }

    public function destroy(RegistrationGroup $registrationGroup)
    {
        return $registrationGroup->delete();
    }
}
