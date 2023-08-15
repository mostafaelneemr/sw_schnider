<?php

namespace App\Modules\System;

 use App\Http\Requests\CompanyFormRequest;
 use App\Models\Company;
use Illuminate\Http\Request;
 use Form;
use Auth;
use Hash;
use Datatables;
 use Illuminate\Support\Facades\Session;

 class CompanyController extends SystemController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if($request->isDataTable){

            $eloquentData = Company::select([
                'id','name'
            ]);

            if($request->withTrashed){
                $eloquentData->onlyTrashed();
            }




            return Datatables::of($eloquentData)
                ->addColumn('id','{{$id}}')
                ->addColumn('name','{{$name}}')
                ->addColumn('action', function($data){
                    return '<a class="btn btn-sm btn-clean btn-icon" href="'.route('system.company.edit',$data->id).'"  ><i class="fa fa-pencil-alt"></i> </a>
                                <a class="btn btn-sm btn-clean btn-icon" href="javascript:void(0);" onclick="deleteRecord(\'' . route( 'system.company.destroy', $data->id ) . '\')"><i class="fa fa-trash" aria-hidden="true"></i> </a>
';
                }) ->rawColumns(['action'])->make(true);
        }else{

            // View Data
            $this->viewData['tableColumns'] = [
                __('ID'),
                 __('Name'),
                 __('Action')
            ];

            $this->viewData['js_columns'] =[
                'id'=>'company.id',
                'name'=>'company.name',
                'action'=>''
            ];

            $this->viewData['breadcrumb'][] = [
                'text'=> __(__('Company'))
            ];

            $this->viewData['add_new'] = [
                'text'=> __('Add Company'),
                'route'=>'system.company.create'
            ];

            if($request->withTrashed){
                $this->viewData['pageTitle'] = __('Deleted Company');
            }else{
                $this->viewData['pageTitle'] = __('Company');
            }

            return $this->view('company.index',$this->viewData);
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
            'text'=> __('company'),
            'url'=> route('system.company.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Create company'),
        ];

        $this->viewData['pageTitle'] = __('Create company');

        return $this->view('company.create',$this->viewData);
    }


    public function store(CompanyFormRequest $CompanyFormRequest)
    {


        $data = Company::create($CompanyFormRequest->all());



        if($data){
            \request()->session()->flash('msg',  __('Data added successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data added successfully'),
                [
                    'url'=> route('system.company.index')
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


    public function show(company $company)
    {

        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text'=> __('company'),
            'url'=> route('system.company.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text'=> __('Edit company'),
        ];

        $this->viewData['pageTitle'] = __('Edit company');

        $this->viewData['result'] = $company;

        return $this->view('company.create',$this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyFormRequest $CompanyFormRequest, Company $company)
    {


        $company->update($CompanyFormRequest->all());


        if($company){
            \request()->session()->flash('msg',     __('Data Updated successfully'));
            \request()->session()->flash('type', 'success');

            return $this->response(
                true,
                200,
                __('Data Updated successfully'),
                [
                    'url'=> route('system.company.index')
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
    public function destroy(Company $company,Request $request)
    {
        $message = __('User deleted successfully');
        $company->delete();
        return $this->response(true,200,$message);
    }

}
