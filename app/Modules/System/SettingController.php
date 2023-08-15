<?php

namespace App\Modules\System;

use App\Models\Setting;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class SettingController extends SystemController
{

    public function __construct(){
        parent::__construct();
        $this->viewData['breadcrumb'] = [
            [
                'text'=> __('Home'),
                'url'=> url('system'),
            ]
        ];
    }

    public function index(){
        $this->viewData['pageTitle'] = __('Setting');

        $settingGroups = Setting::select('group_name')
            ->groupBy('group_name')
            ->where('is_visible','yes')
            ->where('group_name','!=','staff_app')
            ->get();
        $setting = [];
        foreach ($settingGroups as $key => $value) {
            $setting[] = Setting::where('group_name',$value->group_name)->where('is_visible','yes')->orderBy('sort','ASC')->get();
        }


        $this->viewData['settingGroups'] = $settingGroups;
        $this->viewData['setting'] = $setting;

        return $this->view('setting.index',$this->viewData);
    }

    public function update(Request $request){
        $data = $request->all();


        $settingTable = Setting::get(['name','input_type']);
        foreach ($settingTable as $key => $value){

            switch ($value->input_type){
                case 'image':
                    $validator = Validator::make($request->all(), [
                        $value->name => 'nullable|image',
                    ]);
                    if (!$validator->fails() && $request->file($value->name)) {
//                        $image = Uploadimage(null, $request->hasFile('image'), $request->image, 'app/logo/', 'logo', 'logo');
                        $path = $request->file('site_logo')->store('/logo/'.md5(time()).'/'.date('Y/m/d'));
                        if($path){
                            Setting::where(['name'=>$value->name])->where('is_visible','yes')->update(['value'=>$path]);
                        }
                    }
                    break;

                default:
                    if(isset($data[$value->name])){
                        $valueToUpdate = $data[$value->name];
                        if(is_array($valueToUpdate)){
                            $valueToUpdate = @serialize($valueToUpdate);
                        }
                        Setting::where(['name'=>$value->name])->where('is_visible','yes')->update(['value'=>$valueToUpdate]);
                    }else{
                        Setting::where(['name'=>$value->name])->where('is_visible','yes')->update(['value'=>'']);
                    }
                    break;
            }

        }
//        Artisan::call('cache:clear');
//        Artisan::call('config:clear');
        return back()
            ->with('status','success')
            ->with('msg',__('Settings edited successfully'));
    }


}
