@extends('system.layout')
@section('content')
    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">

                {!! Form::open(['route' => isset($result) ? ['system.warehouse.update',$result->id]:'system.warehouse.store','files'=>true, 'method' => isset($result) ?  'PATCH' : 'POST','class'=> 'k-form','id'=> 'main-form','onsubmit'=> 'submitMainForm();return false;']) !!}
                    <div class="k-portlet__body">

                        <div id="form-alert-message"></div>



                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label>{{__('Company')}}<span class="red-star">*</span></label>
                                    {!! Form::select('company_id',[''=>'Select']+$company,isset($result) ? $result->company_id : null,['class'=>'form-control','id'=>'company_id-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="company_id-form-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label>{{__('Name')}}<span class="red-star">*</span></label>
                                    {!! Form::text('name',isset($result) ? $result->name : null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="name-form-error"></div>
                                </div>



                            </div>




                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('city')}}<span class="red-star">*</span></label>
                                {!! Form::text('city',isset($result) ? $result->city : null,['class'=>'form-control','id'=>'city-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="city-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('address')}}<span class="red-star">*</span></label>
                                {!! Form::text('address',isset($result) ? $result->address : null,['class'=>'form-control','id'=>'address-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="address-form-error"></div>
                            </div>



                        </div>



                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('latitude')}}<span class="red-star">*</span></label>
                                {!! Form::text('latitude',isset($result) ? $result->latitude : null,['class'=>'form-control','id'=>'latitude-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="latitude-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('longitude')}}<span class="red-star">*</span></label>
                                {!! Form::text('longitude',isset($result) ? $result->longitude : null,['class'=>'form-control','id'=>'longitude-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="longitude-form-error"></div>
                            </div>



                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('land coordinates')}}</label>
                                {!! Form::text('land_coordinates',isset($result) ? $result->land_coordinates : null,['class'=>'form-control','id'=>'land_coordinates-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="land_coordinates-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('license number')}}<span class="red-star">*</span></label>
                                {!! Form::text('license_number',isset($result) ? $result->license_number : null,['class'=>'form-control','id'=>'license_number-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="license_number-form-error"></div>
                            </div>



                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('license issue date')}}<span class="red-star">*</span></label>
                                {!! Form::text('license_issue_date',isset($result) ? $result->license_issue_date : null,['class'=>'form-control datepicker','style'=>'width:100%','id'=>'license_issue_date-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="license_issue_date-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('license expiry date')}}<span class="red-star">*</span></label>
                                {!! Form::text('license_expiry_date',isset($result) ? $result->license_expiry_date : null,['class'=>'form-control datepicker','style'=>'width:100%','id'=>'license_expiry_date-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="license_expiry_date-form-error"></div>
                            </div>



                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('phone')}}<span class="red-star">*</span></label>
                                {!! Form::text('phone',isset($result) ? $result->phone : null,['class'=>'form-control','id'=>'phone-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="phone-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('manager mobile')}}</label>
                                {!! Form::text('manager_mobile',isset($result) ? $result->manager_mobile : null,['class'=>'form-control','id'=>'manager_mobile-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="manager_mobile-form-error"></div>
                            </div>



                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('email')}}</label>
                                {!! Form::text('email',isset($result) ? $result->email : null,['class'=>'form-control','id'=>'email-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="email-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('land area in square meter')}}</label>
                                {!! Form::text('land_area_in_square_meter',isset($result) ? $result->land_area_in_square_meter : null,['class'=>'form-control','id'=>'land_area_in_square_meter-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="land_area_in_square_meter-form-error"></div>
                            </div>



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
@section('footer')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>

    <script type="text/javascript">



        function submitMainForm(){
            var form = $('#main-form')[0];
            var formData = new FormData(form);
            formSubmit(
                '{{isset($result) ? route('system.warehouse.update',$result->id):route('system.warehouse.store')}}',
                formData,
                function ($data) {
                    window.location = $data.data.url;
                },
                function ($data){
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                    pageAlert('#form-alert-message','error',$data.message);
                }
            );
        }



    </script>
@endsection
