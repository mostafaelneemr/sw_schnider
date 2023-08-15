@extends('system.layout')
@section('content')
    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">

                {!! Form::open(['route' => isset($result) ? ['system.company.update',$result->id]:'system.company.store','files'=>true, 'method' => isset($result) ?  'PATCH' : 'POST','class'=> 'k-form','id'=> 'main-form','onsubmit'=> 'submitMainForm();return false;']) !!}
                    <div class="k-portlet__body">

                        <div id="form-alert-message"></div>



                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>{{__('Name')}}<span class="red-star">*</span></label>
                                    {!! Form::text('name',isset($result) ? $result->name : null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="name-form-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label>{{__('sfda')}}<span class="red-star">*</span></label>
                                    {!! Form::text('sfda',isset($result) ? $result->sfda : null,['class'=>'form-control','id'=>'sfda-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="sfda-form-error"></div>
                                </div>

                            </div>


                        <div class="form-group row">

                        <div class="col-md-6">
                            <label>{{__('commercial record number')}}<span class="red-star">*</span></label>
                            {!! Form::text('commercial_record_number',isset($result) ? $result->commercial_record_number : null,['class'=>'form-control','id'=>'commercial_record_number-form-input','autocomplete'=>'off']) !!}
                            <div class="invalid-feedback" id="commercial_record_number-form-error"></div>
                        </div>

                            <div class="col-md-6">
                                <label>{{__('commercial record Is sue date_hijri')}}<span class="red-star">*</span></label>
                                {!! Form::text('commercial_record_is_sue_date_hijri',isset($result) ? $result->commercial_record_is_sue_date_hijri : null,['class'=>'form-control','id'=>'commercial_record_is_sue_date_hijri-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="commercial_record_is_sue_date_hijri-form-error"></div>
                            </div>

                        </div>





                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('date of birth hijri')}} </label>
                                {!! Form::text('date_of_birth_hijri',isset($result) ? $result->date_of_birth_hijri : null,['class'=>'form-control','id'=>'date_of_birth_hijri-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="date_of_birth_hijri-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('date of birth gregorian')}} </label>
                                {!! Form::text('date_of_birth_gregorian',isset($result) ? $result->date_of_birth_gregorian : null,['class'=>'form-control datepicker','id'=>'date_of_birth_gregorian-form-input','style'=>'width:100%;','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="date_of_birth_gregorian-form-error"></div>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('phone')}}<span class="red-star">*</span></label>
                                {!! Form::text('phone',isset($result) ? $result->phone : null,['class'=>'form-control','id'=>'phone-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="phone-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('extension number')}} </label>
                                {!! Form::text('extension_number',isset($result) ? $result->extension_number : null,['class'=>'form-control','id'=>'extension_number-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="extension_number-form-error"></div>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('email')}}<span class="red-star">*</span></label>
                                {!! Form::text('email',isset($result) ? $result->email : null,['class'=>'form-control','id'=>'email-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="email-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('manager name')}}<span class="red-star">*</span></label>
                                {!! Form::text('manager_name',isset($result) ? $result->manager_name : null,['class'=>'form-control','id'=>'manager_name-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="manager_name-form-error"></div>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('manager phone')}}<span class="red-star">*</span></label>
                                {!! Form::text('manager_phone',isset($result) ? $result->manager_phone : null,['class'=>'form-control','id'=>'manager_phone-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="manager_phone-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('manager mobile')}}<span class="red-star">*</span></label>
                                {!! Form::text('manager_mobile',isset($result) ? $result->manager_mobile : null,['class'=>'form-control','id'=>'manager_mobile-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="manager_mobile-form-error"></div>
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
                '{{isset($result) ? route('system.company.update',$result->id):route('system.company.store')}}',
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
