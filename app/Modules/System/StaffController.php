<?php

namespace App\Modules\System;

use App\Models\{Location, Staff, PermissionGroup};
use Illuminate\Http\Request;
use App\Http\Requests\StaffFormRequest;
use Form;
use Auth;
use Spatie\Activitylog\Models\Activity;
use Datatables;

class StaffController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if($request->isDataTable){

            $eloquentData = Staff::select([
                'id',
                'name',
                 'status',
                 'email'
            ]);
               // ->with('permission_group');

            if($request->withTrashed){
                $eloquentData->onlyTrashed();
            }
            /*
             * Start handling filter
             */

            whereBetween($eloquentData,'DATE(created_at)',$request->created_at1,$request->created_at2);

            if($request->id){
                $eloquentData->where('id','=',$request->id);
            }

            if($request->name){
                $eloquentData->where(function($query) use ($request){
                    $query->where('name','LIKE','%'.$request->name.'%');
                });
            }

            if($request->email){
                $eloquentData->where('email','LIKE','%'.$request->email.'%');
            }



            if($request->status){
                $eloquentData->where('status','=',$request->status);
            }


            return Datatables::of($eloquentData)
//                ->addColumn('id','{{$id}}')
                ->addColumn('name', function($data){
                    return $data->name;
                })
                ->addColumn('email','{{$email}}')
//                ->addColumn('mobile', function($data){
//                    return '<a href="tel:'.$data->mobile.'">'.$data->mobile.'</a>';
//                })

                ->addColumn('status', function($data){
                    if($data->status == 'active'){
                        return '<span class="k-badge  k-badge--success k-badge--inline k-badge--pill">'.__('Active').'</span>';
                    }
                    return '<span class="k-badge  k-badge--danger k-badge--inline k-badge--pill">'.__('In-Active').'</span>';
                })
                ->addColumn('action', function($data){
                    return '<span class="dropdown">
                            <a href="#" class="btn btn-md btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
                              <i class="la la-gear"></i>
                            </a>
                            <div class="dropdown-menu '.( (\App::getLocale() == 'ar') ? 'dropdown-menu-left' : 'dropdown-menu-right').'" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-36px, 25px, 0px);">
                                 <a class="dropdown-item" href="'.route('system.staff.edit',$data->id).'"><i class="la la-edit"></i> '.__('Edit').'</a>
                             </div>
                        </span>';
                })
                ->escapeColumns([])
                ->make(true);
        }
        else{
            // View Data
            $this->viewData['tableColumns'] = [
//                __('ID'),
                __('User'),
                __('Email'),
               __('Status'),
                __('Action')
            ];

            $this->viewData['js_columns'] =[
                'name'=>'staff.name',
                'email'=>'staff.email',
                 'status'=>'staff.status',
                'action'=>'action'
            ];

            $this->viewData['breadcrumb'][] = [
                'text'=> __('Users')
            ];

            $this->viewData['add_new'] = [
                'text'=> __('Add User'),
                'route'=>'system.staff.create'
            ];
//            $this->viewData['filter'] = true;
//            $this->viewData['download_excel'] = true;

            if($request->withTrashed){
                $this->viewData['pageTitle'] = __('Deleted Users');
            }else{
                $this->viewData['pageTitle'] = __('Users');
            }


            $this->viewData['PermissionGroup'] = array_column(PermissionGroup::get()->toArray(),'name','id');

            return $this->view('staff.index',$this->viewData);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('Users'),
            'url'=> route('system.staff.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Create Users'),
        ];

        $this->viewData['pageTitle'] = __('Create User');

//        $this->viewData['PermissionGroup'] = PermissionGroup::get();
//        $this->viewData['locations'] = array_column( Location::all()->toArray(), 'name', 'id' );
        return $this->view('staff.create',$this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffFormRequest $request){
        $requestData = $request->all();
        $requestData['password'] = bcrypt($requestData['password']);

//        if($request->file('avatar')){
//            $path = $request->file('avatar')->store(setting('system_path').'/avatar/'.date('Y/m/d'),'first_public');
//            if($path){
//                $requestData['avatar'] = $path;
//            }
//        }else{
//            unset($requestData['avatar']);
//        }

//        $requestData['location_name'] = Location::find($request->location_id)->name;
//        $list = Location::where('parent_id',$request->location_id)->pluck('id')->toArray();
//        array_push($list,$request->location_id);
//        $requestData['location_list'] = implode(',',$list);

        $insertData = Staff::create($requestData);

        if($insertData){
            return $this->response(
                true,
                200,
                __('Data added successfully'),
                [
                    'url'=> route('system.staff.index')
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
    public function show(Staff $staff,Request $request){

return;
            $this->viewData['breadcrumb'] = [
                [
                    'text' => __('Users'),
                    'url' => route('system.staff.index'),
                ],
                [
                    'text' => $staff->fullname,
                ]
            ];

            $this->viewData['pageTitle'] = __('User Profile');


            $this->viewData['result'] = $staff;
            return $this->view('staff.show', $this->viewData);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff,Request $request){

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('Users'),
            'url'=> route('system.staff.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit (:name)',['name'=> $staff->fullname]),
        ];

        $this->viewData['pageTitle'] = __('Edit User');
        $this->viewData['result'] = $staff;
//        $this->viewData['PermissionGroup'] = PermissionGroup::get();
//        $this->viewData['locations'] = array_column( Location::all()->toArray(), 'name', 'id' );
        return $this->view('staff.create',$this->viewData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(StaffFormRequest $request, Staff $staff)
    {
        $requestData = $request->all();

        if(!empty($requestData['password'])){
            $requestData['password'] = bcrypt($requestData['password']);
        }else{
            unset($requestData['password']);
        }

//        if($request->file('avatar')){
//            $path = $request->file('avatar')->store('/avatar/'.md5(time()).'/'.date('Y/m/d'));
//            if($path){
//                $requestData['avatar'] = $path;
//            }
//        }else{
//            unset($requestData['avatar']);
//        }

//        $requestData['location_name'] = Location::find($request->location_id)->name;
//        $list = Location::where('parent_id',$request->location_id)->pluck('id')->toArray();
//        array_push($list,$request->location_id);
//        $requestData['location_list'] = implode(',',$list);
        $updateData = $staff->update($requestData);

        if($updateData){
            return $this->response(
                true,
                200,
                __('Data modified successfully'),
                [
                    'url'=> route('system.staff.index')
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
    public function getProfile(Staff $staff)
    {
        if ($staff->id != auth()->id()){
            abort(401);
        }
        $this->viewData['breadcrumb'][] = [
            'text'=> __('Staff'),
            'url'=> route('system.staff.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit (:name)',['name'=> auth()->user()->fullname]),
        ];

        $this->viewData['pageTitle'] = __('Update Profile');
        $this->viewData['result'] = auth()->user();

        return $this->view('staff.profile',$this->viewData);
    }
    public function updateProfile(Request $request, Staff $staff)
    {
        if ($staff->id != auth()->id()){
        abort(401);
    }
        $request->validate([
            'name'             => 'required|string',
            'email'                 => 'required|string|email|unique:staff,email,'.$staff->id,
            'avatar'                => 'nullable|image'
        ]);
        $requestData = $request->all();

//        if($request->file('avatar')){
//            $path = $request->file('avatar')->store('/avatar/'.md5(time()).'/'.date('Y/m/d'));
//            if($path){
//                $requestData['avatar'] = $path;
//            }
//        }else{
//            unset($requestData['avatar']);
//        }

        $updateData = $staff->update($requestData);

        if($updateData){
            return $this->response(
                true,
                200,
                __('Data modified successfully'),
                [
                    'url'=> route('system.staff.show',$staff->id)
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


    public function changePassword(){

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Change Password'),
        ];
        $this->viewData['pageTitle'] = __('Change Password');

        return $this->view('staff.change-password',$this->viewData);

    }

    public function changePasswordPost(StaffFormRequest $request){

        if(!\Hash::check($request->currant_password, Auth::user()->password)){
            return $this->response(
                false,
                11001,
                __('Wrong Currant Password')
            );
        }elseif($request->currant_password == $request->password){
            return $this->response(
                false,
                11001,
                __('New password can\'t be currant password')
            );
        }


        $insertData = Staff::where('id',Auth::id())
            ->update([
                'password'=> bcrypt($request->password)
            ]);

        if($insertData){
            return $this->response(
                true,
                200,
                __('password updated successfully'),
                [
                    'url'=> route('system.dashboard')
                ]
            );
        }else{
            return $this->response(
                false,
                11001,
                __('Sorry, we could not update data')
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff,Request $request)
    {
        $message = __('User deleted successfully');
        $staff->delete();
        return $this->response(true,200,$message);
    }

}
