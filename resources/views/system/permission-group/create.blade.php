@extends('system.layout')
@section('content')

    <div class="card card-custom gutter-b">

        <div class="card-body">
                    {!! Form::open(['route' => isset($permission_group) ? ['system.permission-group.update',$permission_group->id]:'system.permission-group.store','files'=>true, 'method' => isset($permission_group) ?  'PATCH' : 'POST','class'=> 'k-form']) !!}
                    <div class="k-portlet__body">
                        @if($errors->any())
                            <div class="alert alert-custom alert-danger fade show mb-5" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">{{__('Some fields are invalid please fix them')}}</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                    </button>
                                </div>
                            </div>
                        @elseif(Session::has('status'))
                            <div class="alert alert-custom alert-success fade show mb-5" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">{{ Session::get('msg') }}</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                    </button>
                                </div>
                            </div>
                        @endif


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>{{__('Name')}}<span class="red-star">*</span></label>
                                {!! Form::text('name',isset($permission_group) ? $permission_group->name : null,['class'=>'form-control'.formError($errors,'name',true),'autocomplete'=>'off']) !!}
                                {!! formError($errors,'name') !!}
                            </div>



                        </div>


                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="javascript:void(0);" class="btn btn-primary text-center" onclick="$('input[name=\'permissions[]\']').prop('checked',true)">
                                    <i class="fa fa-star"></i> {{__('Select All')}}
                                </a>
                                <a href="javascript:void(0);" class="btn btn-outline-warning text-center" onclick="$('input[name=\'permissions[]\']').prop('checked',false)">
                                    <i class="fa fa-star-o"></i> {{__('Deselect All')}}
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            @foreach($permissions as $permission)
                                <div class="col-md-12">
                                    <div style="margin-bottom: 20px;" class="bs-callout-primary callout-border-left callout-bordered p-2 permissions">
                                        <h4 class="primary">{{ucfirst($permission['name'])}}</h4>
                                        <div class="row">
                                            @foreach($permission['permissions'] as $key=>$val)
                                                <label class="col-sm-4">
                                                    {!! Form::checkbox("permissions[]", "$key", isset($permission_group->id) ? !array_diff($val,$currentpermissions) : false) !!}
                                                    {!! __(ucfirst(str_replace('-',' ',$key))) !!}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>


                        <div class="k-portlet__foot">
                            <div class="k-form__actions">
                                <div class="row" style="float: right;">
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                </div>
                            </div>
                        </div>



                    </div>
                    {!! Form::close() !!}
                </div>
            </div>


        @endsection

