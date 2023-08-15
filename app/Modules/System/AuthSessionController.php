<?php

namespace App\Modules\System;

use App\Models\Invoice, Staff, App\Models\PermissionGroup;
use Illuminate\Http\Request;
use App\Http\Requests\StaffFormRequest;
use Form;
use Auth;
use Hash;
use App\Models\AuthSession;

class AuthSessionController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if($request->isDataTable){

            $eloquentData = AuthSession::select([
                'id',
                'ip',
                'guard_name',
                'user_id',
                'user_agent',
                'created_at',
                'updated_at',
            ])
                ->orderBy('updated_at','desc');



            return datatables()->eloquent($eloquentData)
                ->addColumn('id','{{$id}}')
                ->addColumn('user_id',function($data) {
                    return '<a target="_blank" href="'.route('system.staff.show',$data->user_id).'">'.$data->user->fullname.'</a>';
                })
                ->addColumn('ip','{{$ip}}')
                ->addColumn('user_agent','{{$user_agent}}')
                ->addColumn('created_at',function($data){
                    return $data->created_at->diffForHumans();
                })
                ->addColumn('updated_at',function($data){
                    return $data->updated_at->diffForHumans();
                })
                ->addColumn('action',function($data){
                    return '<a class="dropdown-item" href="javascript:void(0);" onclick="deleteRecord(\''.route('system.staff.delete-auth-sessions',['id'=>$data->id]).'\')"><i class="la la-trash-o"></i> '.__('Delete').'</a>';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            // View Data
            $this->viewData['tableColumns'] = [
                __('ID'),
                __('User'),
                __('Ip'),
                __('User Agent'),
                __('Created At'),
                __('Updated At'),
                __('Action')
            ];

            $this->viewData['breadcrumb'][] = [
                'text'=> __('Auth Sessions')
            ];

            $this->viewData['js_columns'] =[
                'id'=>'auth_session.id',
                'user_id'=>'auth_session.user_id',
                'ip'=>'auth_session.ip',
                'user_agent'=>'auth_session.user_agent',
                'created_at'=>'auth_session.created_at',
                'updated_at'=>'auth_session.updated_at',
                'action'=>'action'
            ];


            if($request->withTrashed){
                $this->viewData['pageTitle'] = __('Deleted Auth Sessions');
            }else{
                $this->viewData['pageTitle'] = __('Auth Sessions');
            }

            $this->viewData['PermissionGroup'] = array_column(PermissionGroup::get()->toArray(),'name','id');

            return $this->view('auth-session.index',$this->viewData);
        }
    }

    public function deleteAuthSession(Request $request){
        if(empty($request->id))
            return ['status'=>false,'msg'=>__('ID is Required')];

        $auth_session = AuthSession::where(['id'=>$request->id])->find($request->id);
        if(empty($auth_session))
            return ['status'=>false,'msg'=>__('Session Not Found')];

        if($auth_session->delete()){
            return ['status'=>true,'msg'=>__('Session Deleted')];
        }

        return ['status'=>false,'msg'=>__('Session Not Deleted')];

    }


}
