<?php

namespace App\Modules\System;

 use App\Http\Requests\WarehouseFormRequest;
 use App\Models\Company;
 use App\Models\Warehouse;
use Illuminate\Http\Request;
 use Form;
use Auth;
use Hash;
use Datatables;
 
 class WarehouseController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if($request->isDataTable){

            $eloquentData = Warehouse::select([
                'warehouse.id','warehouse.name','company.name as company_name'
            ])->join('company','company.id','warehouse.company_id');




            return Datatables::of($eloquentData)
                ->addColumn('id','{{$id}}')
                ->addColumn('company_name','{{$company_name}}')
                ->addColumn('name','{{$name}}')
                ->addColumn('action', function($data){
                    return '<a class="btn btn-sm btn-clean btn-icon" href="'.route('system.warehouse.edit',$data->id).'"  ><i class="fa fa-pencil-alt"></i> </a>
                                <a class="btn btn-sm btn-clean btn-icon" href="javascript:void(0);" onclick="deleteRecord(\'' . route( 'system.warehouse.destroy', $data->id ) . '\')"><i class="fa fa-trash" aria-hidden="true"></i> </a>
';
                }) ->rawColumns(['action'])->make(true);
        }else{

            // View Data
            $this->viewData['tableColumns'] = [
                __('ID'),
                 __('company'),
                 __('Name'),
                 __('Action')
            ];

            $this->viewData['js_columns'] =[
                'id'=>'warehouse.id',
                'company_name'=>'company.name',
                'name'=>'warehouse.name',
                'action'=>''
            ];

            $this->viewData['breadcrumb'][] = [
                'text'=> __(__('warehouse'))
            ];

            $this->viewData['add_new'] = [
                'text'=> __('Add warehouse'),
                'route'=>'system.warehouse.create'
            ];

            if($request->withTrashed){
                $this->viewData['pageTitle'] = __('Deleted warehouse');
            }else{
                $this->viewData['pageTitle'] = __('warehouse');
            }

            return $this->view('warehouse.index',$this->viewData);
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
            'text'=> __('warehouse'),
            'url'=> route('system.warehouse.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Create warehouse'),
        ];

        $this->viewData['pageTitle'] = __('Create warehouse');
        $this->viewData['company'] = array_column(Company::all()->toArray(),'name','id') ;

        return $this->view('warehouse.create',$this->viewData);
    }


    public function store(WarehouseFormRequest $warehouseFormRequest)
    {


        $data = Warehouse::create($warehouseFormRequest->all());



        if($data){
            \request()->session()->flash('msg',  __('Data added successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data added successfully'),
                [
                    'url'=> route('system.warehouse.index')
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


    public function show(warehouse $warehouse)
    {

        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('warehouse'),
            'url'=> route('system.warehouse.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit warehouse'),
        ];

        $this->viewData['pageTitle'] = __('Edit warehouse');

        $this->viewData['result'] = $warehouse;
        $this->viewData['company'] = array_column(Company::all()->toArray(),'name','id') ;

        return $this->view('warehouse.create',$this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(WarehouseFormRequest $warehouseFormRequest, Warehouse $warehouse)
    {


        $warehouse->update($warehouseFormRequest->all());


        if($warehouse){
            \request()->session()->flash('msg',     __('Data Updated successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data Updated successfully'),
                [
                    'url'=> route('system.warehouse.index')
                ]
            );
        }else{
            return $this->response(
                false,
                11001,
                __('Sorry, we could not Update the data')
            );
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse,Request $request)
    {
        $message = __('User deleted successfully');
        $warehouse->delete();
        return $this->response(true,200,$message);
    }

}
