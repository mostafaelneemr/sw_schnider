<?php

namespace App\Modules\System;

 use App\Http\Requests\InventoryFormRequest;
 use App\Models\Warehouse;
 use App\Models\Inventory;
use Illuminate\Http\Request;
 use Form;
use Auth;
use Hash;
use Datatables;
 
 class InventoryController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if($request->isDataTable){

            $eloquentData = Inventory::select([
                'inventory.id','inventory.name','warehouse.name as warehouse_name'
            ])->join('warehouse','warehouse.id','inventory.warehouse_id');




            return Datatables::of($eloquentData)
                ->addColumn('id','{{$id}}')
                ->addColumn('warehouse_name','{{$warehouse_name}}')
                ->addColumn('name','{{$name}}')
                ->addColumn('action', function($data){
                    return '<a class="btn btn-sm btn-clean btn-icon" href="'.route('system.inventory.edit',$data->id).'"  ><i class="fa fa-pencil-alt"></i> </a>
                                <a class="btn btn-sm btn-clean btn-icon" href="javascript:void(0);" onclick="deleteRecord(\'' . route( 'system.inventory.destroy', $data->id ) . '\')"><i class="fa fa-trash" aria-hidden="true"></i> </a>
';
                }) ->rawColumns(['action'])->make(true);
        }else{

            // View Data
            $this->viewData['tableColumns'] = [
                __('ID'),
                 __('warehouse'),
                 __('Name'),
                 __('Action')
            ];

            $this->viewData['js_columns'] =[
                'id'=>'inventory.id',
                'warehouse_name'=>'warehouse.name',
                'name'=>'inventory.name',
                'action'=>''
            ];

            $this->viewData['breadcrumb'][] = [
                'text'=> __(__('inventory'))
            ];

            $this->viewData['add_new'] = [
                'text'=> __('Add inventory'),
                'route'=>'system.inventory.create'
            ];

            if($request->withTrashed){
                $this->viewData['pageTitle'] = __('Deleted inventory');
            }else{
                $this->viewData['pageTitle'] = __('inventory');
            }

            return $this->view('inventory.index',$this->viewData);
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
            'text'=> __('inventory'),
            'url'=> route('system.inventory.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Create inventory'),
        ];

        $this->viewData['pageTitle'] = __('Create inventory');
        $this->viewData['warehouse'] = array_column(Warehouse::all()->toArray(),'name','id') ;

        return $this->view('inventory.create',$this->viewData);
    }


    public function store(InventoryFormRequest $inventoryFormRequest)
    {


        $data = Inventory::create($inventoryFormRequest->all());



        if($data){
            \request()->session()->flash('msg',  __('Data added successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data added successfully'),
                [
                    'url'=> route('system.inventory.index')
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


    public function show(Inventory $inventory)
    {

        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('inventory'),
            'url'=> route('system.inventory.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit inventory'),
        ];

        $this->viewData['pageTitle'] = __('Edit inventory');

        $this->viewData['result'] = $inventory;
        $this->viewData['warehouse'] = array_column(Warehouse::all()->toArray(),'name','id') ;

        return $this->view('inventory.create',$this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryFormRequest $inventoryFormRequest, Inventory $inventory)
    {


        $inventory->update($inventoryFormRequest->all());


        if($inventory){
            \request()->session()->flash('msg',     __('Data Updated successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data Updated successfully'),
                [
                    'url'=> route('system.inventory.index')
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
    public function destroy(Inventory $inventory,Request $request)
    {
        $message = __('User deleted successfully');
        $inventory->delete();
        return $this->response(true,200,$message);
    }

}
