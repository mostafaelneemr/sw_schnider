<?php


// @TODO: Handle Status HTML
function statusColor($status){
    return $status;
}

function countVisits(){
    $visitsCount = \App\Models\Visits::whereNull('comment_by_staff_id');
    if(!staffCan('show-tree-users-data',\Auth::id())){
        $visitsCount->whereIn('visits.staff_id',\Auth::user()->managed_staff_ids());
    }
    return $visitsCount->count();

}



function checkReviewedMerchants(){

    $NonReviewdMerchants = \App\Models\Merchant::where('is_reviewed','no')->with('staff')->get();
    if(!empty($NonReviewdMerchants)) {

        if (!empty(setting('callcenter_ids_notifications'))) {
            $monitorStaff = \App\Models\Staff::whereIn('id', explode("\n", setting('callcenter_ids_notifications')))
                ->get();

            foreach ($monitorStaff as $key => $value) {
                Mail::to($value)
                    ->send(new \App\Mail\ReviewWaitingMerchants($NonReviewdMerchants) );

            }
        }
    }

}

function getStaffName($id,array $data){
    $firstname = array_column($data,'firstname','id');
    $lastname = array_column($data,'lastname','id');
    return @($firstname[$id].' '.$lastname[$id]);
}

function adminDefineUser($model,$id,$content){
    if($model == 'App\Models\Staff'){
        return '<a href="'.route('system.staff.show',[$id]).'">'.$content.'</a>';
    }elseif($model == 'App\Models\User'){
        return '<a href="'.route('system.user.show',[$id]).'">'.$content.'</a>';
    }else{
        return '<a href="'.route('merchant.staff.show',[$id]).'">'.$content.'</a>';
    }
}

function adminDefineUserWithName($model,$id,$lang){
    switch($model){
        case 'App\Models\MerchantStaff':
            $content = \App\Models\MerchantStaff::where('id','=',$id)->first()->Name;
            return '<a href="'.route('merchant.staff.show',[$id]).'">'.$content.'</a>';
            break;

        case 'App\Models\User':
            $content = \App\Models\User::where('id','=',$id)->first()->FullName;
            return '<a href="'.route('system.users.show',[$id]).'">'.$content.'</a>';
            break;

        case 'App\Models\Merchant':
            $content = \App\Models\User::Merchant('id','=',$id)->first()->{'name_'.$lang};
            return '<a href="'.route('merchant.merchant.show',[$id]).'">'.$content.'</a>';
            break;

        case 'App\Models\Staff':
        default:
            $content = \App\Models\Staff::where('id','=',$id)->first()->Fullname;
            return '<a href="'.route('system.staff.show',[$id]).'">'.$content.'</a>';
            break;

    }
}


function formError($error,$fieldName,$checkHasError = false){

    if($checkHasError){
        if($error->has($fieldName)){
            return ' is-invalid';
        }else{
            return null;
        }
    }

    if($error->has($fieldName)){
        $return = '<div class="invalid-feedback">';

        foreach ($error->get($fieldName) as $errorMsg) {
            if(is_array($errorMsg)){
                $return .= implode(',',$errorMsg).'<br />';
            }else{
                $return .= $errorMsg.'<br />';
            }
        }
        $return .= '</div>';
        return $return;
    }else{
        return null;
    }

}


function generateMenu(array $array)
{

//	var_dump($array);
    $return = '';
    if (!isset( $array['url'] )) {
        $array['url'] = '#';
    }

    if (!isset( $array['icon'] )) {
        $array['icon'] = null;
    }

    if (!isset( $array['class'] )) {
        $array['class'] = null;
    }

    if (!isset( $array['aClass'] )) {
        $array['aClass'] = null;
    }


    if (!empty( $array['permission'] )) {

        if (is_array( $array['permission'] )) {
            $oneTrue = false;
            foreach ($array['permission'] as $key => $value) {
                if (staffCan( $value )) {
                    $oneTrue = true;
                    break;
                }
            }

            if (!$oneTrue) {
                return false;
            }
        } else {
            if (!staffCan( $array['permission'] )) {
                return false;
            }
        }
    }


    if (isset( $array['permission'] )) {
        if (!staffCan( $array['permission'] ))
            return false;
    }

    $should_open = '';
    if (isset( $array['permission'] ) && MenuRoute( $array['permission'] )) {
        $array['class'] .= ' active';
        $should_open = 'menu-item-open' ;
    }

    if (isset($array['sub'])) {

//        if(in_array('full_url',$array['segments'])){
////            $should_open = in_array(request()->segment(1).'/'.request()->segment(2), ($array['segments'] ?? [])) ? 'menu-item-open' : '';
////        }else{
////            $should_open = in_array(request()->segment(1), ($array['segments'] ?? [])) ? 'menu-item-open' : '';
////        }

        $return .= '<li class="menu-item menu-item-submenu '.$should_open.'" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
										<span class=\'svg-icon menu-icon\'>' . $array['icon'] . '</span>
                                <span class="menu-text">' .trans($array['text']).  '</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">';
    }else {
        $styling = url()->current() == $array['url'] ? 'style="color: white;"' : '';
        if(empty($array['icon'])){
            $array['icon'] =  '  <span class=\'svg-icon menu-icon\'> <i '.$styling.' class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i></span>';
        }
        $return .= '<li class="menu-item menu-item-submenu" aria-haspopup="true">
                            <a href="' . $array['url'] . '" class="menu-link">
       <span class=\'svg-icon menu-icon\'>' . $array['icon'] . '</span>
                                <span '.$styling.' class="menu-text">' .trans($array['text']).  '</span>
                            </a>
                        ';
    }


    if (isset( $array['sub'] ) && !empty( $array['sub'] )) {
        $return .= '<ul class="menu-subnav">';
        foreach ($array['sub'] as $key => $value) {
            $return .= generateMenu( $value );
        }
        $return .= '  </ul> </div>  </li>';
    }
    return $return;

}

function GenerateHorizMenu(array $array, $sub=false){
    $data['class']  = ((isset($array['class']))?' '.$array['class']:'');
    $data['icon']   = ((isset($array['icon']))?''.$array['icon']:'');
    $data['url']    = ((isset($array['url']))?$array['url']:'#');


    if(isset($array['onclick'])){
        $data['onclick'] = ' onclick="'.$array['onclick'].'" ';
    }else{
        $data['onclick'] = '';
    }


    if(!$sub){
        $data['class'] = 'nav-item '.$data['class'];
        $data['data-menu'] = 'dropdown';
        $data['aclass'] = 'dropdown-toggle nav-link';
    } else {
        if(isset($array['sub']) && count($array['sub'])) {
            $data['class'] = 'dropdown-submenu ' . $data['class'];
            $data['data-menu'] = 'dropdown-submenu';
            $data['aclass'] = 'dropdown-item dropdown-toggle';
        } else {
            $data['class'] = '';
            $data['data-menu'] = '';
            $data['aclass'] = 'dropdown-item';
        }
    }

    if(isset($array['permission'])){
        if(!merchantcan($array['permission']))
            return false;
    }

    if(isset($array['url']) && MenuRoute($array['permission']))
        $data['class'] .= ' active';

    $menu = "<li data-menu='{$data['data-menu']}' class='dropdown {$data['class']}'>
            <a ".$data['onclick']." href='{$data['url']}' data-toggle='dropdown' class='{$data['aclass']}' ".((!$sub)?'aria-expanded="false"':null).">
                <i class='{$data['icon']}'></i><span>{$array['text']}</span>
            </a>";
    if(isset($array['sub']) && count($array['sub'])){
        $menu .= "<ul class='dropdown-menu'>";
        foreach($array['sub'] as $key=>$item){
            $menu .= GenerateHorizMenu($item,true);
        }
        $menu .= "</ul>";
    }
    $menu .= "</li>";
    return $menu;
}

function MenuRoute($routename){
    $requestRoute = request()->route()->getName();
    if(is_array($routename)){
        if(in_array($requestRoute,$routename)){
            return true;
        }
        return false;
    }

    return ($requestRoute == $routename) ? true : false;
}

function staffCan($routename,$staffId = null){
    return true;
    if($staffId && $staffId == request()->user()->id){
        $staffId = null;
    }

    $userObj = $staffId ? \App\Models\Staff::where('id',$staffId)->first() : request()->user();

    static $permissions;
    if(is_null($permissions)){
        $permissions = \App\Models\Staff::StaffPerms($userObj->id)->toArray();
    }

    if(is_array($routename)) {
        $arr = array_diff($routename,$permissions);
        return (!$arr) ? true : ((count($arr) == count($routename))? false:true);
    } else {
        return (in_array($routename,$permissions)) ? true : false;
    }
}

function cLang()
{
    return "en";
    $la = Session::get('locale');
    if (!$la) {
        $la = "ar";
    }
    App::setlocale($la);
    return App::getLocale();
}
