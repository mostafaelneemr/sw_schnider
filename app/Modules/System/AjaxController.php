<?php

namespace App\Modules\System;

 use App\Models\Driver;
 use App\Models\Staff;
 use App\Models\PermissionGroup;
 use App\Models\User;
use Illuminate\Http\Request;
use Form;
use Auth;
use App;

class AjaxController extends SystemController{

    public function index(Request $request){

        switch ($request->type) {


            case 'saveLog':
                if (!empty($request->desc) && !empty($request->model) && !empty($request->id)) {
                    save_log(__($request->desc), $request->model, $request->id);
                    return [];
                }
                return [];
                break;

            case 'readNotification':
                foreach (Auth::user()->unreadNotifications as $notification) {
                    $notification->markAsRead();
                }
                break;

            case 'getNextAreas':
                return AreasData::getNextAreas($request->id);
                break;


            case 'dropdownMenuArea':
                $id = $request->id;


                if ($id == 0) {
                    return [
                        'area_type_id' => 1,
                        'areas' => Area::where('area_type_id', 1)->get(['id', 'name_' . \App::getLocale() . ' as name'])
                    ];
                }

                $data = AreasData::getNextAreas($id);

                $returnData = [];
                if (!empty($data['areas'])) {
                    foreach ($data['areas'] as $key => $value) {
                        $returnData[] = [
                            'id' => $value['id'],
                            'name' => $value['name_' . \App::getLocale()]
                        ];
                    }

                    return [
                        'area_type_id' => $data['type']->id,
                        'areas' => $returnData
                    ];
                }

                return [];

                break;

            case 'drivers':
                $word = $request->word;

                $data = Driver::where('status', 'active')
                    ->where(function ($query) use ($word) {
                        $query->where('name', 'LIKE', '%' . $word . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $word . '%');
                    })
                    ->get(['id','name', 'mobile']);

                if(!$data) return [];

                $returnData = [];
                foreach ($data as $key => $value){
                    $returnData[] =  ['id'=> $value->id, 'value'=> $value->name.'('.$value->id.')'];
                }
                return $returnData;

                break;

            case 'vendors':
                $word = $request->word;
                $data = User::where('status', 'active')
                    ->where('type','company')
                    ->where(function ($query) use ($word) {
                        $query->where('name', 'LIKE', '%' . $word . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $word . '%');
                    })
                    ->get(['id','name']);

                if(!$data) return [];

                $returnData = [];
                foreach ($data as $key => $value){
                    $returnData[] =  ['id'=> $value->id, 'value'=> $value->name.'('.$value->id.')'];
                }
                return $returnData;

                break;
            case 'users':
                $word = $request->word;

                $data =  User::where('status', 'active')
                    ->where('type','person')
                    ->where(function ($query) use ($word) {
                        $query->where('name', 'LIKE', '%' . $word . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $word . '%');
                    })
                    ->get(['id','name']);

                if(!$data) return [];

                $returnData = [];
                foreach ($data as $key => $value){
                    $returnData[] =  ['id'=> $value->id, 'value'=> $value->name.'('.$value->id.')'];
                }
                return $returnData;

                break;


            case 'staff':
                $word = $request->word;


                $data = Staff::where('status', 'active')
                    ->where(function ($query) use ($word) {
                        $query->where('firstname', 'LIKE', '%' . $word . '%')
                            ->orWhere('lastname', 'LIKE', '%' . $word . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $word . '%');
                    })
                    ->get(['id',
                        \DB::raw('CONCAT(firstname," ",lastname) as value')
                    ]);

                if(!$data) return [];
                return $data;

//                $returnData = [];
//                foreach ($data as $key => $value){
//                    $returnData[] =  ['id'=> $value->id, 'value'=> $value->firstname.' '.$value->lastname];
//                }
//
//                return $returnData;

                break;
            case 'area':
                $word = $request->word;

                $data = Area::where(function($query) use ($word) {
                    $query->where('name_ar','LIKE','%'.$word.'%')
                        ->orWhere('name_en','LIKE','%'.$word.'%');
                })->get([
                    'id'
                ]);

                if($data->isEmpty()){
                    return [];
                }

                $result = [];

                foreach ($data as $key => $value){
                    $result[] = [
                        'id'=> $value->id,
                        'value'=> str_replace($word,'<b>'.$word.'</b>',implode(' -> ',AreasData::getAreasUp($value->id,true) ))
                    ];

                    if(setting('area_select_type') == '2'){
                        $areaDown = AreasData::getAreasDown($value->id);
                        if(count($areaDown) > 1){
                            array_shift($areaDown);
                            foreach ($areaDown as $aK => $aV){
                                $result[] = [
                                    'id'=> $aV,
                                    'value'=> str_replace($word,'<b>'.$word.'</b>',implode(' -> ',AreasData::getAreasUp($aV,true) ))
                                ];
                            }
                        }
                    }

                }

                return $result;

                break;
            case 'sensors':
                $word = $request->word;
                $data = App\Models\Sensor::where('status', 'active')
                    ->where(function ($query) use ($word) {
                        $query->where('name', 'LIKE', '%' . $word . '%')
                            ->orWhere('serial_number', 'LIKE', '%' . $word . '%')
                            ->orWhere('location_name', 'LIKE', '%' . $word . '%');
                    })
                    ->get(['id','name','location_name']);

                $returnData = [];
                foreach ($data as $value){
                    $returnData[] =  ['id'=> $value->id, 'value'=> $value->name.' ('.$value->location_name.' )'];
                }

                return $returnData;

                break;

            case 'make_as_read':

                \Illuminate\Support\Facades\Auth::user()->notifications()->update(['read_at'=>date('Y-m-d H:i:s')]);
                return ['status'=>true];
                break;

            case 'check_notify' :
                $notify_count = \Illuminate\Support\Facades\Auth::user()->unreadNotifications()->count();
                $notify = \Illuminate\Support\Facades\Auth::user()->notifications()->select('id','data','read_at','created_at')->orderby('created_at','desc')->limit(50)->get();

                return ['status'=>true,'number'=>$notify_count,'notify'=>$notify];

                break;
        }

    }

}
