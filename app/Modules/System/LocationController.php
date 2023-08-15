<?php

namespace App\Modules\System;

use App\Models\{AlarmRules, CloudUsers, Location, PermissionGroup, Sensor};
use Illuminate\Http\Request;
use App\Http\Requests\CloudUsersFormRequest;
use Form;
use Auth;
use Spatie\Activitylog\Models\Activity;
use Datatables;

class LocationController extends SystemController
{
    public function create(){
        $this->viewData['breadcrumb'][] = [
            'text'=> __('Location'),
            'url'=> route('system.rules-notifications.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Create Location'),
        ];

        $this->viewData['pageTitle'] = __('Create Location');

        return $this->view('locations.create',$this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'serial_number'=>'required|unique,sensors:serial_number',
            'location_id'=>'required'
        ]);
        $requestData = $request->all();

        $insertData = Sensor::create($requestData);
        if($insertData){
            return $this->response(
                true,
                200,
                __('Data added successfully'),
                [
                    'url'=> route('system.dashboard')
                ]
            );
        }else{
            return $this->response(
                false,
                11001,
                __('Sorry, we could not add the data')
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(CloudUsers $staff,Request $request){


            $this->viewData['breadcrumb'] = [
                [
                    'text' => __('CloudUsers'),
                    'url' => route('system.cloud-users.index'),
                ],
                [
                    'text' => $staff->fullname,
                ]
            ];

            $this->viewData['pageTitle'] = __('CloudUsers Profile');


            $this->viewData['result'] = $staff;
            return $this->view('cloud-users.show', $this->viewData);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(CloudUsers $staff,Request $request){

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('CloudUsers'),
            'url'=> route('system.cloud-users.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit (:name)',['name'=> $staff->fullname]),
        ];

        $this->viewData['pageTitle'] = __('Edit CloudUsers');
        $this->viewData['result'] = $staff;
        $this->viewData['PermissionGroup'] = PermissionGroup::get();

        return $this->view('cloud-users.create',$this->viewData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Sensor $sensor)
    {
        $request->validate([
            'name'=>'required',
            'serial_number'=>'required|unique,sensors:serial_number',
            'location_id'=>'required'
        ]);
        $requestData = $request->all();
        $updateData = $sensor->update($requestData);

        if($updateData){
            return $this->response(
                true,
                200,
                __('Data modified successfully'),
                [
                    'url'=> route('system.dashboard')
                ]
            );
        }else{
            return $this->response(
                false,
                11001,
                __('Sorry, we could not edit the data')
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(CloudUsers $staff,Request $request)
    {
        $message = __('CloudUsers deleted successfully');
        $staff->delete();
        return $this->response(true,200,$message);
    }
    public function locationsAction(Request  $request){
       if ($request->action =='delete'){
           Location::where('id',$request->location_id)->delete();
           return $this->response(true,200,'Location deleted successfully');
       }
        if ($request->action =='rename'){
            Location::where('id',$request->location_id)->update(['name'=>$request->name]);
            return $this->response(true,200,'Location Re-named successfully');
        }
        if ($request->action =='change_parent'){
            Location::where('id',$request->location_id)->update(['parent_id'=>$request->parent]);
            return $this->response(true,200,'Location Re-named successfully');
        }
        if ($request->action =='add_sub'){
            Location::create([
                'name'=>$request->name,
                'parent_id'=>!empty($request->parent)?$request->parent:null,
                'created_by' => auth()->id()
            ]);
            return $this->response(true,200,'Location sub added successfully');
        }
    }
    public function locations(Request  $request){

        $locations = Location::all();
//        dd($locations);
        return $this->response(true,200,'', $locations);
    }
}
