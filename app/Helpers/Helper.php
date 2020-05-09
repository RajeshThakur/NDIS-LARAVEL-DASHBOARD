<?php
if (!function_exists('human_file_size')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function human_file_size($bytes, $decimals = 2)
    {
        $sz = 'BKMGTPE';
        $factor = (int)floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
 
    }
}


/**
 * Dumps a given variable along with some additional data.
 *
 * @param mixed $var
 * @param bool  $pretty
 */
function dmdd($var, $pretty = true)
{
    $backtrace = debug_backtrace();
    echo "\n<pre>\n";
    if (isset($backtrace[0]['file'])) {
        echo $backtrace[0]['file'] . "\n\n";
    }
    echo "Type: " . gettype($var) . "\n";
    echo "Time: " . date('c') . "\n";
    echo "---------------------------------\n\n";
    ($pretty) ? print_r($var) : var_dump($var);
    echo "</pre>\n";
    die;
}

if (!function_exists('slug_to_human')) {
    /**
     * Returns a human viewable form of a slug/db_var
     * */
    function slug_to_human($var)
    {
        return ucwords( str_replace('-',' ', str_replace('_',' ', $var) ) );
    }
}

if(!function_exists('slugify')){
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
 
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
 
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
 
        // trim
        $text = trim($text, '-');
 
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
 
        // lowercase
        $text = strtolower($text);
 
        if (empty($text)) {
            return 'n-a';
        }
 
        return $text;
    }
}
 
if (!function_exists('in_arrayi')) {
 
    /**
     * Checks if a value exists in an array in a case-insensitive manner
     *
     * @param mixed $needle
     * The searched value
     *
     * @param $haystack
     * The array
     *
     * @param bool $strict [optional]
     * If set to true type of needle will also be matched
     *
     * @return bool true if needle is found in the array,
     * false otherwise
     */
    function in_arrayi($needle, $haystack, $strict = false)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }
}


//Pretty array printer
if ( !function_exists('pr') ){
    function pr( $arr , $kill = 0){
       $root = debug_backtrace();
       $file = str_replace($_SERVER['DOCUMENT_ROOT'],'',$root[0]['file']);
       $string = '</br>Line: '.$root[0]['line'].'</br>File : '.$file;

       echo "<pre>";        
       print_r($arr);        
       echo "</pre>";
       

       if($kill == 1){            
           die($string);
       }
    }
}


if ( !function_exists('ddon') ){
    function ddon(){
        $root = debug_backtrace();
        return  " Dumped in " .$root[0]['file'] ." on line " . $root[0]['line'];
    }   
}

/**
 * Function to get Protected Values of a Class
 * @var $obj Object of the Protected Class
 * @var $var Var name to get from the class
 */
function getProtectedVar($obj, $var){
    $propGetter = Closure::bind(  function($prop){return $this->$prop;}, $obj, $obj );
    return $propGetter($var);
}

/**
* Returns field of variable (arr[key] or obj->prop), otherwise the third parameter
* @param array/object $arr_or_obj
* @param string $key_or_prop
* @param mixed $else
*/
function issetKey($arr_or_obj, $key_or_prop, $default){
    $result = $default;

    if( isset( $arr_or_obj ) && is_array( $arr_or_obj ) && isset( $arr_or_obj[$key_or_prop] ) ){
        $result = $arr_or_obj[$key_or_prop];
    }
    elseif( isset( $arr_or_obj ) && is_object( $arr_or_obj ) && isset( $arr_or_obj->$key_or_prop ) ){
        $result = $arr_or_obj->$key_or_prop;
    }

    return $result;
}

if ( !function_exists('clearCache') ){
    
    function clearCache($cache=false,$route=false,$config=false){
        
        if( $cache ) \Artisan::call('cache:clear');
        if( $route ) \Artisan::call('config:clear');
        if( $config ) \Artisan::call('route:clear');
        
    }
}

if ( !function_exists('valOrAlt') ){
    function valOrAlt( $object, $key, $altObject, $altKey='' ){

        if( is_array($object) && isset( $object[$key] ) ){
            return $object[$key];
        }
        if( is_object($object) &&  isset( $object->$key ) ){
            return $object->$key;
        }
        if( is_array($altObject) && isset( $altObject[$altKey] ) ){
            return $altObject[$altKey];
        }
        if( is_object($altObject) && isset( $altObject->$altKey ) ){
            return $altObject->$altKey;
        }
        return '';
    }
}

if ( !function_exists('getDistance') ){
    function getDistance( $parti_cords, $sw_cords )
    {
        $r = 6378137; // Earth’s mean radius in meter

        $dLat = ($parti_cords['lat'] - $sw_cords['lat']) * (M_PI / 180);
        $dLong = ($parti_cords['lng'] - $sw_cords['lng']) * (M_PI / 180);
     
        $a = sin( $dLat / 2 ) * sin( $dLat / 2 ) + 
             cos(($parti_cords['lat']) * (M_PI / 180) ) * cos(($sw_cords['lat']) * (M_PI / 180) ) *
             sin( $dLong / 2 ) * sin( $dLong / 2 );
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $r * $c;
        
        return $d;
    }
}

function isApiCall()
{
    return strpos( request()->getUri(), '/api/v') !== false;
}

function apiError( $msg,  $code){
    return response()->json([ "status"=>false, "error" => $msg ], $code);
}

function apiResponse( Array $arr, $code ){
    $arr['status'] = true;
    return response()->json( $arr, $code);
}


function logMsg( $str, $obj=null ){
    \Log::critical( [ 'Message' => $str ] );
    if($obj)
        \Log::critical( $obj );
}

function reportAndRespond( $ex,  $code){
    \Log::critical(  $ex->getMessage(), ['file' => $ex->getFile(), 'line'=>$ex->getLine() ] );
    return response()->json([ "status"=>false, "message" => trans('msg.api.general'), 'error'=>$ex->getMessage() ], $code);
}

function dateCarbon($_date){
    return \Carbon\Carbon::parse( $_date);
}

function todayDate(){
    return dbToDate(today() );
}

function dateToDB( $_date ){
    try{
        // logMsg("Converting dateToDB", $_date);
        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.date_format') );

        return $_date ? \Carbon\Carbon::createFromFormat( config('panel.date_input_format'), $_date)->format(config('panel.date_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date)->format(config('panel.date_format')) : null;
    }
    
}

function dbToDate( $_date ){
    try{
        // logMsg("Converting dbToDate", $_date);

        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.date_input_format') );

        if(isApiCall())
            return $_date;
        else
            return $_date ? \Carbon\Carbon::createFromFormat( config('panel.date_format'), $_date)->format(config('panel.date_input_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date)->format(config('panel.date_input_format')) : null;
    }
}

function datetimeToDB( $_date ){
    try{
        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.db_datetime_format') );
            
        // logMsg("converting datetimeToDB :".$_date);

        return $_date ? \Carbon\Carbon::createFromFormat( config('panel.datetime_format'), $_date)->format(config('panel.db_datetime_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date)->format(config('panel.db_datetime_format')) : null;
    }
}
function dbToDatetime( $_date ){

    if(isset($_date) && !empty($_date)) {
        try{
            if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
                return $_date->format(config('panel.datetime_format') );

            if(isApiCall())
                return $_date;
            else
                return $_date ? \Carbon\Carbon::createFromFormat( config('panel.db_datetime_format'), $_date)->format(config('panel.datetime_format')) : null;
        }
        catch(Exception $exception) {
            return $_date ? \Carbon\Carbon::parse( $_date )->format(config('panel.datetime_format')) : null;
        }
    }
    return null;
}

function dbDatetimeToTime( $_date ){
    try{
        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.time_format') );

        if(isApiCall())
            return $_date;
        else
            return $_date ? \Carbon\Carbon::createFromFormat( config('panel.db_datetime_format'), $_date)->format(config('panel.time_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date )->format(config('panel.time_format')) : null;
    }
}


function dbDateToTime( $_date ){
    try{
        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.time_format') );

        if(isApiCall())
            return $_date;
        else
            return $_date ? \Carbon\Carbon::createFromFormat( config('panel.date_format'), $_date)->format(config('panel.time_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date )->format(config('panel.time_format')) : null;
    }
}

function dbDatetimeToDate( $_date ){
    try{
        if($_date instanceof \Illuminate\Support\Carbon || $_date instanceof \Carbon\Carbon)
            return $_date->format(config('panel.time_format') );

        if(isApiCall())
            return $_date;
        else
            return $_date ? \Carbon\Carbon::createFromFormat( config('panel.db_datetime_format'), $_date)->format(config('panel.date_input_format')) : null;
    }
    catch(Exception $exception) {
        return $_date ? \Carbon\Carbon::parse( $_date )->format(config('panel.date_input_format')) : null;
    }
}



function is_serialized( $data, $strict = true ) {
    // if it isn't a string, it isn't serialized.
    if ( ! is_string( $data ) ) {
        return false;
    }
    $data = trim( $data );
    if ( 'N;' == $data ) {
        return true;
    }
    if ( strlen( $data ) < 4 ) {
        return false;
    }
    if ( ':' !== $data[1] ) {
        return false;
    }
    if ( $strict ) {
        $lastc = substr( $data, -1 );
        if ( ';' !== $lastc && '}' !== $lastc ) {
            return false;
        }
    } else {
        $semicolon = strpos( $data, ';' );
        $brace     = strpos( $data, '}' );
        // Either ; or } must exist.
        if ( false === $semicolon && false === $brace ) {
            return false;
        }
        // But neither must be in the first X characters.
        if ( false !== $semicolon && $semicolon < 3 ) {
            return false;
        }
        if ( false !== $brace && $brace < 4 ) {
            return false;
        }
    }
    $token = $data[0];
    switch ( $token ) {
        case 's':
            if ( $strict ) {
                if ( '"' !== substr( $data, -2, 1 ) ) {
                    return false;
                }
            } elseif ( false === strpos( $data, '"' ) ) {
                return false;
            }
            // or else fall through
        case 'a':
        case 'O':
            return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
        case 'b':
        case 'i':
        case 'd':
            $end = $strict ? '$' : '';
            return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
    }
    return false;
}


function formatBookingMsgSubject($bookingOrderId){
    return "Booking #$bookingOrderId Messages";
}

function registration_group_dd( $parentName="parent_reg_group", $parentId="parent_reg_group_id", $childName="in_house_group", $childId="in_house_", $selected = array('parent_id'=>-1,'child_grps'=>-1), $attr=[], $label="Select Registration Group", $size="form-group shedow-column " ){

    $parentGrpIDs = [];
    $inHouseParent = [];
    if($selected['parent_id'] != -1){

        foreach($selected['parent_id'] as $key=>$value){
        
            $parentGrpIDs[] = $value['parent_id'];
            if($value['inhouse'] == 1)
                $inHouseParent[] = $value['parent_id'];
        }

    }
    
    $regGroups = \App\RegistrationGroup::where('parent_id','==',0)->orderBy('title','asc')->get();

    $_html = '';
    $_attr = '';
    if(!empty($attr)){
        foreach($attr as $key => $val)
            $_attr .= " {$key}={$val} ";
    }
    $regGrpSplit = explode('_',$childId);

    $_html .= '<div class="col-sm-12 shedow-column ">';
                
                $_html .= "<div class=''>";
                    //if there are any previously saved records
                    if( $selected['parent_id'] != -1 ){

                        $_html .= "<div class='{$size}'>";
                        $_html .= '<label>'.$label.'</label>';
                        $_html .= "<div class='input-group'>";
                            $_html .= "<select id='grp_no_".$regGrpSplit[2]."' name='{$parentName}[]' multiple='multiple' data-validation='required' class='form-control select2 reg_group' rel='{$childId}' $_attr >";
                            
                            foreach($regGroups as $key=>$regGroup){
                                
                                if ( in_array($regGroup->id,$parentGrpIDs) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }

                                if ( in_array($regGroup->id,$inHouseParent) ){
                                    $inHouse = '1';
                                }else{
                                    $inHouse = '0';
                                }
                                
                            
                                $_html .= "<option data-in-house='{$inHouse}' value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                            }
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            
                        $_html .= "</div>";
                        $_html .= "</div>";
                    }else{
                        $_html .= "<div class='{$size}'>";
                        $_html .= '<label>'.$label.'</label>';
                        $_html .= "<div class='input-group'>";
                            $_html .= "<select id='grp_no_".$regGrpSplit[2]."' name='{$parentName}[]' multiple='multiple' data-validation='required' class='form-control select2 reg_group' rel='{$childId}' $_attr >";
                            //$_html .= "<option value='0' selected >".trans('global.registrationGroup.select_group')."</option>";
                            // $_html .= "<option value='0' ". ( $selected['parent_id'] == 0 ) ? 'selected'  : '' ." >".trans('global.registrationGroup.select_group')."</option>";
                            foreach($regGroups as $key=>$regGroup){
    
                                if ( in_array($regGroup->id,$parentGrpIDs) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }
                                
                            
                                $_html .= "<option data-in-house='0' value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                            }
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            
                        $_html .= "</div>";
                        $_html .= "</div>";
                    }
                
                    
                    //if there are any previously saved records
                    if( $selected['parent_id'] != -1 ){

                        $_html .= "<div class='{$size} '><label>In House Registration Groups</label>";
                        $_html .= "<div class='input-group shedow-column '>";
                            $_html .= "<select id='in_house_".$regGrpSplit[2]."' name='{$childName}[]' multiple='multiple' data-validation='required' class='form-control select2 in_house' rel='{$childId}' $_attr >";

                            foreach($regGroups as $key=>$regGroup){
                                
                                if ( in_array($regGroup->id,$inHouseParent) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }                                

                                if ( in_array($regGroup->id, $parentGrpIDs) ){
                                    $_html .= "<option value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                                }
                            
                                
                            }

                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            $_html .= "<span class='in_house' id='{$parentId}'></span>";
                        $_html .= "</div>";
                        $_html .= "</div>";
                        
                    }else{

                        $_html .= "<div class='{$size} '><label>In House Registration Groups</label>";
                        $_html .= "<div class='input-group shedow-column'>";
                            $_html .= "<select id='in_house_".$regGrpSplit[2]."' name='{$childName}[]' multiple='multiple' data-validation='required' class='form-control select2 in_house' rel='{$childId}' $_attr >";
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            $_html .= "<span class='in_house' id='{$parentId}'></span>";
                        $_html .= "</div>";
                        $_html .= "</div>";

                    }
                       
                $_html .= "</div>";
                
    $_html .= "</div>";
// pr('die',1);
    return $_html;

}

//provider profice registration group for old data//
function registration_group_old_dd( $parentName="parent_reg_group", $parentId="parent_reg_group_id", $childName="in_house_group", $childId="in_house_", $selected = array('count'=>null, 'parent_id'=>-1,'in_house'=>-1), $attr=[], $label="Select Registration Group", $size="form-group col-sm-12 shedow-column " ){

    
    $parentGrpIDs = [];
    $inHouseParent = [];
    if($selected['parent_id'] != -1){
        foreach($selected['parent_id'] as $key=>$value){
            $parentGrpIDs[] = $value;
        }
    }

    if($selected['in_house'] != -1){
        foreach($selected['in_house'] as $key=>$value){
            $inHouseParent[] = $value;
        }
    }
    

    
    $regGroups = \App\RegistrationGroup::where('parent_id','==',0)->orderBy('title','asc')->get();

    $_html = '';
    $_attr = '';

    if(!empty($attr)){
        foreach($attr as $key => $val)
            $_attr .= " {$key}={$val} ";
    }

    $regGrpSplit = explode('_',$childId);

    $_html .= '<div class="form-group col-sm-12 shedow-column ">';
                
                $_html .= "<div class='row'>";
                    //if there are any previously saved records
                    if( $selected['parent_id'] != -1 ){

                        $_html .= "<div class='{$size}'>";
                        $_html .= '<label>'.$label.'</label>';
                        $_html .= "<div class='input-group'>";
                            $_html .= "<select id='grp_no_".$regGrpSplit[2]."' name='{$parentName}[]' multiple='multiple' data-validation='required' class='form-control select2 reg_group' rel='{$childId}' $_attr >";
                            
                            foreach($regGroups as $key=>$regGroup){
                                
                                if ( in_array($regGroup->id,$parentGrpIDs) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }

                                if ( in_array($regGroup->id,$inHouseParent) ){
                                    $inHouse = '1';
                                }else{
                                    $inHouse = '0';
                                }
                                
                            
                                $_html .= "<option data-in-house='{$inHouse}' value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                            }
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            
                        $_html .= "</div>";
                        $_html .= "</div>";
                    }else{
                        $_html .= "<div class='{$size}'>";
                        $_html .= "<div class='input-group'>";
                            $_html .= "<select id='grp_no_".$regGrpSplit[2]."' name='{$parentName}[]' multiple='multiple' data-validation='required' class='form-control select2 reg_group' rel='{$childId}' $_attr >";
                            //$_html .= "<option value='0' selected >".trans('global.registrationGroup.select_group')."</option>";
                            // $_html .= "<option value='0' ". ( $selected['parent_id'] == 0 ) ? 'selected'  : '' ." >".trans('global.registrationGroup.select_group')."</option>";
                            foreach($regGroups as $key=>$regGroup){
    
                                if ( in_array($regGroup->id,$parentGrpIDs) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }
                                
                            
                                $_html .= "<option data-in-house='0' value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                            }
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            
                        $_html .= "</div>";
                        $_html .= "</div>";
                    }
                
                    
                    //if there are any previously saved records
                    if( $selected['parent_id'] != -1 ){

                        $_html .= "<div class='{$size} '><label>In House Registration Groups</label>";
                        $_html .= "<div class='input-group shedow-column '>";
                            $_html .= "<select id='in_house_".$regGrpSplit[2]."' name='{$childName}[]' multiple='multiple' data-validation='required' class='form-control select2 in_house' rel='{$childId}' $_attr >";

                            foreach($regGroups as $key=>$regGroup){
                                
                                if ( in_array($regGroup->id,$inHouseParent) ){
                                    $isSelected = 'selected';
                                }else{
                                    $isSelected = '';
                                }                                

                                if ( in_array($regGroup->id, $parentGrpIDs) ){
                                    $_html .= "<option value='{$regGroup->id}'  {$isSelected} >{$regGroup->title}</option>";
                                }
                            
                                
                            }

                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            $_html .= "<span class='in_house' id='{$parentId}'></span>";
                        $_html .= "</div>";
                        $_html .= "</div>";
                        
                    }else{

                        $_html .= "<div class='{$size} '><label>In House Registration Groups</label>";
                        $_html .= "<div class='input-group shedow-column'>";
                            $_html .= "<select id='in_house_".$regGrpSplit[2]."' name='{$childName}[]' multiple='multiple' data-validation='required' class='form-control select2 in_house' rel='{$childId}' $_attr >";
                            $_html .= "</select>";
                            $_html .= "<i class='inputicon fa fa-caret-down' aria-hidden='true'></i>";
                            $_html .= "<span class='in_house' id='{$parentId}'></span>";
                        $_html .= "</div>";
                        $_html .= "</div>";

                    }
                       
                $_html .= "</div>";
                
    $_html .= "</div>";
// pr('die',1);
    return $_html;

}




function registration_group_edit_dd($regGrps) {
    // dd($regGrp['parent_id']);
    $_html = '<table class="table table-bordered table-striped table-hover datatable dataTable no-footer reg_price_table" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">';
    $_html .= '<thead>';
    $_html .= '<tr>';
    $_html .= '<th>';
    $_html .= 'State';
    $_html .= '</th>';
    $_html .= '<th>';
    $_html .= 'Registration Group';
    $_html .= '</th>';
    $_html .= '<th>';
    $_html .= 'Item Number';
    $_html .= '</th>';
    $_html .= '<th>';
    $_html .= 'Price Limit';
    $_html .= '</th>';
    $_html .= '<th>';
    $_html .= 'Amount to Pay to Support Worker';
    $_html .= '</th>';
    $_html .= '</thead>';
    $_html .= '<tbody>';
 
    $ifQuoteYes = 0;
    foreach($regGrps as $key0=>$arrVal) {
 
        $states = DB::table('states')->where('id',$arrVal['state'])->orderBy('full_name','asc')->get()->toArray();
 
        $stateName = $states[0]->full_name;
 
        $stateID = $states[0]->id;
        $_html .= '<input type="hidden" name="state_id['.$key0.']" value="'.$stateID.'"> ';
        
        foreach($arrVal['parent_id'] as $key1=>$arrVal1) {
 
            $parentData = DB::table('registration_groups')->where('id',$arrVal1)->orderBy('title','asc')->get()->toArray();
 
            $regSubGroups =  Illuminate\Support\Facades\DB::table('registration_groups')->where('parent_id', $arrVal1)->get()->toArray();
 
            $parentName = $parentData[0]->title;
 
            $parentID = $parentData[0]->id;
            $_html .= '<input type="hidden" name="parent_id['.$key0.']['.$key1.']" value="'.$parentID.'"> ';
 
            foreach($regSubGroups as $key2=>$regData) {
 
                if($regData->quote_required == 'N' || $regData->quote_required == 'n' ) {

                    $newVal = 0.0;
                    $parentData = DB::table('provider_reg_groups')->where('reg_group_id',$regData->id)->get()->pluck('cost','reg_group_id')->toArray();
                    if(isset($parentData[$regData->id]))
                        $newVAl = $parentData[$regData->id];
                    
                    $_html .= '<tr class="row_['.$key0.']['.$key1.']">';
 
                        $_html .= '<td>';
                            $_html .= $stateName;
                            //$_html .= '<input type="hidden" name="state_id['.$key0.']['.$key1.']" value="'.$stateID.'"> ';
                        $_html .= '</td>';
 
                        $_html .= '<td>';
                            $_html .= $parentName;
                            //$_html .= '<input type="hidden" name="parent_id['.$key0.']['.$key1.']" value="'.$parentID.'"> ';
                        $_html .= '</td>';
 
                        $_html .= '<td>';
                            $_html .= $regData->title;
                            //$_html .= '<input type="hidden" name="reg_id['.$key0.']['.$key1.']" value="'.$regData->id.'"> ';
                        $_html .= '</td>';
 
                        $_html .= '<td class="price_limit">';
                            $_html .= $regData->price_limit;
                        $_html .= '</td>';
 
                        $_html .= '<td>';

                            $_html .= '<input type="number" class="form-control entered_price" name="reg_amt['.$key0.']['.$key1.']['.$regData->id.']" min="0" value="'.$newVAl.'" required> ';

                            $_html .= '<span class="">/ '.$regData->unit;'</span>';
                        $_html .= '</td>';
 
                    $_html .= '</tr>';
 
                    $ifQuoteYes++;
                }
 
            }
 
        }
 
    }
 
    $_html .= '</tbody>';
 
    $_html .= '</table>';
 
    if($ifQuoteYes == 0) {
        return '<h3>All item number is quoted.</h3>';
    }
 
    return $_html;
 
 }



//------------------------------------------------------------
// Document Functions

function regGroupById( $regGrpId ){
    if($regGrpId){
        return \App\RegistrationGroup::find($regGrpId );
    }
    return new \App\RegistrationGroup;
}


/**
 * Function returns the parent Reg Group ID based on given Child ID
 * @arg $regGrpId interger id of hild reg group
 */
function regGroupByChildId( $regGrpId ){
    if($regGrpId){
        return \App\RegistrationGroup::find( \App\RegistrationGroup::where('id', $regGrpId)->first()->parent_id );
    }
    return new \App\RegistrationGroup;
}

function regGroupTitleByID($regGrpId){
    $regGrp = regGroupById($regGrpId);
    if($regGrp){
        return $regGrp->title;
    }
    return null;
}



//------------------------------------------------------------
// Document Functions
function getDocumentUrl( $docId ){
    if($docId && intval($docId) > 0 ){
        $document = \App\Documents::where( 'id', $docId)->select('url')->first();
        return $document->url;
    }
    return $docId;
}


//------------------------------------------------------------
// Logged in User Functions

function getUser(){
    return \Auth::user();
}

function getAvatarByInitials($letter, $color=null){
    $arrX = array("blue", "sky", "black", "brown", "yellow", "orange", "gray");
    
    if(!$color)
        $colorCSSClass = 'avtr-'.$arrX[array_rand($arrX)];
    else
        $colorCSSClass = 'avtr-'.$color;

    return '<span class="profileImage size-60 '.$colorCSSClass.' img-circle profile-image">'.$letter.'</span>';
}

function getAvatarById($user, $form = false){
    $url = getDocumentUrl($user->avatar);
    
    if( $url ){
        if( $form ) return $url ;
        else return '<span class="profileImage size-60 img-circle profile-image" style="background-image: url('.$url.')" ></span>';
    }
    return null;
}

function getUserAvatar( $userId = null, $form = false, $color = null ){
    
    if($userId)
        $user = \App\User::find($userId);
    else
        $user = \Auth::user();
        
    if( isset($user->id) ){
        if($user->avatar){
            return getAvatarById($user, $form );
        }else{
            return getAvatarByInitials( substr(ucfirst($user->first_name), 0, 1), $color );
        }
    }
    return null;
}

function getUserFullName( $userId = null ){
    if($userId)
        $user = \User::find($userId);
    else
        $user = \Auth::user();
        
    if( isset($user->id) ){
        return $user->first_name . ' ' . $user->last_name;
    }
    return null;
}

function getUserRoleTitle( $userId = null ){
    if($userId)
        $user = \User::find($userId);
    else
        $user = \Auth::user();
    
    if( isset($user->id) ){
        return $user->roles()->first()->title;
    }
    return null;
}

function getTotalMessage() {
    

    $user = \Auth::user();

    $countMessage = 0;

    foreach ($user->unreadNotifications as $notification) {

        if($notification['notifiable_id'] == \Auth::user()->id)
            $countMessage++;

    }

    return $countMessage;


}

function newMessages( $count = 0) {

   $user = \Auth::user();
   
   $latest =   ($user->threadsWithNewMessages())->map(function ($item, $key) {

                $msg =  Dmark\Messenger\Models\Message::whereThreadId( $item->id )->get();
                // dump($msg);
                $newMsg['id'] = $item->id;
                $newMsg['subject'] = $item->subject;
                $newMsg['body'] = $msg[0]->body;
                $newMsg['time'] = $msg[0]->updated_at;

                $sender = \App\User::find($msg[0]->user_id);
                $newMsg['name'] = $sender['first_name']. ' ' .$sender['last_name'];
                return $newMsg;

            });
       
    ($count != 0) ? $return = $latest->take($count) : $return = $latest;   
   return $return;


}

function getName($first_name, $last_name) {
    return $first_name.' '.$last_name;
}


function checkUserRole( int $role ){

    $user =  \Auth::user();
    $roles = $user->roles->pluck('id');
    
    if( $roles->contains($role) )
        return true;
    else
        return false;

}






// End of Logged in User Functions
//------------------------------------------------------------