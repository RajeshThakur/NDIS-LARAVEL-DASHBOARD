<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistrationGroupRequest;
use App\Http\Requests\UpdateRegistrationGroupRequest;
use App\RegistrationGroup;
use App\ProviderRegGroups;

class RegistrationGroupsController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('registration_group_access'), 403);

        $registrationGroups = RegistrationGroup::all();

        return view('admin.registrationGroups.index', compact('registrationGroups'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('registration_group_create'), 403);

        $list = RegistrationGroup::where('parent_id', '==', 0)->get();
        
        return view('admin.registrationGroups.create')->with('data', $list);
    }

    public function store(StoreRegistrationGroupRequest $request)
    {
        abort_unless(\Gate::allows('registration_group_create'), 403);

        $registrationGroup = RegistrationGroup::create($request->all());

        return redirect()->route('admin.registration-groups.index')->with('success', 'Registration group added');
    }

    public function edit(RegistrationGroup $registrationGroup)
    {
        abort_unless(\Gate::allows('registration_group_edit'), 403);

        $list = RegistrationGroup::where('parent_id', '==', 0)->get();

        return view('admin.registrationGroups.edit', compact('registrationGroup'))->with('data', $list);;
    }

    public function update(UpdateRegistrationGroupRequest $request, RegistrationGroup $registrationGroup)
    {
        abort_unless(\Gate::allows('registration_group_edit'), 403);

        $registrationGroup->update($request->all());

        return redirect()->route('admin.registration-groups.index')->with('success', 'Registration group updated');
    }

    public function show(RegistrationGroup $registrationGroup)
    {
        abort_unless(\Gate::allows('registration_group_show'), 403);

        return view('admin.registrationGroups.show', compact('registrationGroup'));
    }

    public function destroy(RegistrationGroup $registrationGroup)
    {
        abort_unless(\Gate::allows('registration_group_delete'), 403);

        $registrationGroup->delete();

        // return back();
        return redirect()->route('admin.registration-groups.index');
    }



    public function getParentsList() {
        $list = RegistrationGroup::where('parent_id', '==', 0);
        return view('forms.parent_id')->with('data', $list);
    }

    public function getChildList(Request $request) {

        //$request->validate([ 'parentID' => 'bail|required|integer' ]);
        $user = \Auth::user();
        $providerRegGrps = null;
        
        $html = '<div class="row child-grps">';
        
        foreach($request->parentID as $key=>$value) {

            if($request->stateID > 0){

                $providerRegGrps = ProviderRegGroups::where('user_id', $user->id)
                                                 ->where('state_id',$request->stateID)
                                                 ->where('parent_reg_group_id',$value)
                                                 ->get()->toArray();

            }
            

            $data =  RegistrationGroup::where('parent_id', '=', $value)->get();
        
            foreach( $data as $key=>$item){
                $chldLimit = -1;
                if($providerRegGrps != null){
                    foreach($providerRegGrps as $k=>$val){
                        if($item->id == $val['reg_group_id']){
                            $chldLimit = $val['cost'];
                        }
                    }
                }
                if($chldLimit == -1)
                    $chldLimit = '';
                
                if($item->quote_required == 'n' || $item->quote_required == 'N'){
                    // $filedDisabled = 'pointer-events:none';
                    $itemQuote = '<input type="number" class="form-control entered_price" id="user_price_'.$item->id.'" name="item['.$request->current.']['.$value.']['.$item->id.']" value="'.$chldLimit.'" style="pointer-events:auto" required /><span>/ '.$item->unit.'</span>';
                } else {
                    // $filedDisabled = '';
                    $itemQuote = '<p>Price by quote only</p><input type="hidden" class="form-control"  name="item['.$request->current.']['.$value.']['.$item->id.']" value="-1"/>';
                }
                $html .= '<div class="col-sm-12">
                            <div class="row border-bottom">
                                <div class="col-sm-5 item-number">
                                    <label>Item number</label>
                                    <span class="item-number" >'.$item->title.'</span>
                                </div>
                                <div class="col-sm-2 price-limit">
                                    <label>Price Limit</label>
                                    <span class="price-limit">'.$item->price_limit.'</span>
                                </div>
                                <div class="col-sm-5 item-number">
                                    <div class="form-group ndis-list-price">
                                    <label>Amount to pay to support worker</label> 
                                    '. $itemQuote .'
                                    
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

        }
        
        $html .= "</div>";

        return response()->json([ 'status'=>true,  'html' => (string) $html ]);
    }


    public function getParentChilds(Request $request) {

        $request->validate([ 'parentID' => 'bail|required|integer' ]);

        $data =  RegistrationGroup::where('parent_id', '=', $request->parentID)->get();

        return $data;
    }

}
       