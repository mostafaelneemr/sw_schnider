@extends('system.layout')
@section('header')
    <style>
        div.col-md-6{
            padding: 5px;
        }
        .red-star{
            color: red;
            font-weight: bold;
        }
        label{
            font-weight: bold !important;
        }
    </style>
    @endsection
@section('content')
    <!--begin::Row-->
    <div class="card ">
        {!! Form::open(['route' => isset($result) ? ['system.staff.update',$result->id]:'system.staff.store','files'=>true, 'method' => 'POST','class'=> 'k-form','id'=> 'main-form','onsubmit'=> 'submitMainForm();return false;']) !!}
            <div class="card-body">
                <div class="k-portlet__body">
                        <div id="form-alert-message"></div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>{{__('Name')}}<span class="red-star">*</span></label>
                                    {!! Form::text('name',isset($result) ? $result->name : null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="name-form-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label>{{__('Serial Number')}}<span class="red-star">*</span></label>
                                    {!! Form::select('serial_number',$serials,isset($result) ? $result->serial_number : null,['class'=>'form-control','id'=>'serial_number-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="serial_number-form-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label>{{__('Location')}}<span class="red-star">*</span></label>
                                    {!! Form::select('location_id',$locations,isset($result) ? $result->location_id : null,['class'=>'form-control','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="location_id-form-error"></div>
                                </div>

                        </div>
            </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-3 col-12 offset-md-9">
                        <button type="submit" class="btn btn-block  btn-dark-75 waves-effect">
                            {{ __('Save')  }}
                        </button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}

    </div>

@endsection
@section('footer')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script type="text/javascript">




            function submitMainForm(){
                var formData = new FormData($('#main-form')[0]);
                formSubmit(
                    '{{route('system.sensor.store')}}',
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
        function ChangeValue(val,id) {

            if (val == 'active') {
                document.getElementById(id).value ='in-active';

            } else {
                document.getElementById(id).value ='active';
            }
        }
        $('select').select2({
            placeholder: "{{__('Select')}}",
            allowClear: true
        });
    </script>
@endsection
