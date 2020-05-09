<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\RegistrationGroup;
use Illuminate\Support\Facades\DB;

trait Common
{
    /**
     * Function to Create a dropdown of the Registration Group Parents
     * 
     * @param string $name
     * @param string $id
     * @param integer $selected
     * @param array $attr
     * @return String
     * 
     */
    public static function getDropDown( $name="reg_group", $id="parent_reg_group_id", $selected = 0, $attr=[] )
    {
        $regGroups = RegistrationGroup::where('parent_id','==',0)->orderBy('title','asc')->get();

        $_html = '';
        $_attr = '';

        $attr['class'] = (isset($attr['class'])) ? $attr['class'].' reg_group' : 'reg_group';

        if(!empty($attr)){
            foreach($attr as $key => $val)
                $_attr .= " {$key}={$val} ";
        }

        $_html = "<select name='reggroups[]' required='required' $_attr multiple='multiple'>";
        $_html .= "<option value='0' selected disabled>".trans('global.registrationGroup.select_group')."</option>";
        foreach($regGroups as $key=>$regGroup){
            $selected = '';
            $_html .= "<option value='{$regGroup->id}'>{$regGroup->title}</option>";
        }
        $_html .= "</select>";

        return $_html;
    }


    /**
     * Function to Create a dropdown of the Registration Group Parents for selected id's of collection's
     * 
     * @param string $name
     * @param string $id
     * @param integer $selected
     * @param array $attr
     * @return String
     * 
     */
    public static function getDropDownByIds( $regGrpIds, $name="reg_group", $id="parent_reg_group_id", $selected = 0, $attr=[] )
    {
        $regGroups = RegistrationGroup::whereIn('id', $regGrpIds)->orderBy('title','asc')->get();

        $_html = '';
        $_attr = '';

        $attr['class'] = (isset($attr['class'])) ? $attr['class'].' reg_group' : 'reg_group';

        if(!empty($attr)){
            foreach($attr as $key => $val)
                $_attr .= " {$key}={$val} ";
        }

        $_html = "<select name='reggroups[]' required='required' $_attr multiple='multiple'>";
        $_html .= "<option value='0' selected disabled>".trans('global.registrationGroup.select_group')."</option>";
        foreach($regGroups as $key=>$regGroup){
            $selected = '';
            $_html .= "<option value='{$regGroup->id}'>{$regGroup->title}</option>";
        }
        $_html .= "</select>";

        return $_html;
    }


    /**
     * Function to Create a dropdown of States of Australia
     * 
     * @param string $name
     * @param string $id
     * @param integer $selected
     * @param array $attr
     * @return String
     * 
     */
    public static function getStates($name="states",$id="states" , $selected = 0, $attr=[] )
    { 
        // $data = session()->all();
        // dump($data);
        // dump($name);
        // dump($id);
        // dump($selected);
        // dump($attr);
        $states = DB::table('states')->orderBy('full_name','asc')->get();

        $_html = '';
        $_attr = '';
        if(!empty($attr)){
            foreach($attr as $key => $val)
                $_attr .= " {$key}={$val} ";
        }
        //dump(old('state[0]'));
        $_html = "<select class='states' data-validation='required' name='$name' id='$id' $_attr >";
        $_html .= "<option value='0' selected > ".trans('global.states.select_state')."</option>";
        
        foreach($states as $key=>$state){
            $sel="";
            if( $selected == $state->id)$sel ="selected";
            $_html .= "<option value='{$state->id}' $sel>{$state->full_name}</option>";
        }
        $_html .= "</select>";
        //dump(old('state[0]',$selected));
        return $_html;
    }

    
    /**
     * Function to Create a task for Users
     * 
     * @param array $taskData required fields in array [ name, due_date, start_time, end_time, provider_id ]
     * @param array $tags
     * @param array $assigned_tos
     * @return \App\Task | null
     * 
     */
    public function addTask( array $taskData, array $tags, $assigned_tos  )
    {
        
        if(auth()->user()){
            $user = auth()->user();
            $task = \App\Task::create([
                                    'name' =>$taskData['name'],
                                    'due_date' => $taskData['due_date'],
                                    'start_time' => $taskData['start_time'],
                                    'end_time' => $taskData['end_time'],
                                    'location' => issetKey($taskData,'location',''),
                                    'lng' => issetKey($taskData,'lng',''),
                                    'lat' => issetKey($taskData,'lat',''),
                                    'description' => issetKey($taskData,'description',''),
                                    'status_id' => issetKey($taskData,'status_id',1),
                                    'provider_id' => $taskData['provider_id'],
                                    'created_by_id' => $user->id,
                                    'color_id' => $taskData['color_id'],
                                ]);

            $task->tags()->sync($tags);            
            $task->assigned_to_update()->sync($assigned_tos);

            return $task;

        }

        return null;
    }


    //onboarding step checker
    public function check_steps( $participant )
    {
        $operationFormFill = [];
        if($participant->onboarding_step == 3){

            $opFormObj = \App\OperationalForms::where('user_id', $participant['user_id'])
                                          ->whereIn('template_id', [2, 3, 10])
                                          ->get()
                                          ->pluck('template_id');
            
            // dd($opFormObj);
            
            foreach($opFormObj as $key=>$value) {

                if($value == 2) {
                    $operationFormFill['care_plan'] = true;
                }
                if($value == 3) { 
                    $operationFormFill['client_consent_form'] = true;
                }
                if($value == 10) {
                    $operationFormFill['risk_assessment'] = true;
                }

            }
            // dd($operationFormFill);
        }

        return $operationFormFill;
    } 
}
