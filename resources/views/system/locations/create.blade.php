@extends('system.layout')
@section('header')
    <style>
        div.col-md-6 {
            padding: 5px;
        }

        .red-star {
            color: red;
            font-weight: bold;
        }

        .hide_time {
            display: none;
        }

    </style>
@endsection
@section('content')
    <!--begin::Row-->
    {!! Form::open(['route' => isset($result) ? ['system.staff.update',$result->id]:'system.staff.store','files'=>true, 'method' => isset($result) ?  'PATCH' : 'POST','class'=> 'k-form','id'=> 'main-form','onsubmit'=> 'submitMainForm();return false;']) !!}

    <div class="card ">
        <div class="card-header" style="font-weight: bold">
            Name and set the condtions
        </div>
        <div class="card-body">
            <div class="k-portlet__body">
                <div id="form-alert-message"></div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>{{__('Rule name')}}<span class="red-star">*</span></label>
                        {!! Form::text('name',isset($result) ? $result->name : null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                        <div class="invalid-feedback" id="name-form-error"></div>
                    </div>

                    <div class="col-md-4">
                        <label>{{__('if')}}</label>
                        {!! Form::select('type',['Temperature'=>'Temperature','Pressure'=>'Pressure','Differential pressure'=>'Differential pressure',
'Humidity'=>'Humidity','Open closed'=>'Open closed','Sensor is lost'=>'Sensor is lost','Water usage'=>'Water usage','Electricity usage'=>'Electricity usage','Pulse counter'=>'Pulse counter'

],null,['class'=>'form-control','style'=>'width:100%','id'=>'type','onchange'=>'changeType();']) !!}
                    </div>

                    <div class="col-md-4 hide_div">
                        <label>{{__('is')}}</label>
                        {!! Form::select('type',['more_than'=>'Above','less_than'=>'Below'],null,['class'=>'form-control','style'=>'width:100%']) !!}
                    </div>
                    <div class="col-md-1 hide_div">
                        <label></label>
                        <input type="text" class="form-control" value="0">
                    </div>
                    <div class="col-md-1 hide_div">
                        <label class="dgree_type" style="margin-top:34px;">{{__('°C')}}</label>

                    </div>

                    <div class="col-md-6 recipients">
                        <label>{{__('Email/SMS')}}</label>
                        {!! Form::email('emails[]', null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                        <div class="invalid-feedback" id="permission_group_id-form-error"></div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-primary add"
                           style="color: #D4D5DF;background-color: #272935;margin-top: 25px;"
                           onclick="onPlusImageClick()">{{__('Add RECIPIENTS')}}</a>
                    </div>


                    <div class="col-md-6">
                        <label>{{__('Send the notification')}}</label>
                        {!! Form::select('type',['immediately'=>'immediately','after'=>'after'],null,['class'=>'form-control','style'=>'width:100%','id'=>'send_type','onchange'=>'sendType();']) !!}
                    </div>

                    <div class="col-md-2 hide_time">
                        <label style="margin-top:34px;">{{__('threshold is exceeded for')}}</label>
                    </div>
                    <div class="col-md-1 hide_time">
                        <label></label>
                        {!! Form::number('minutes',0,['class'=>'form-control','style'=>'width:100%','id'=>'type']) !!}
                    </div>
                    <div class="col-md-1 hide_time">
                        <label style="margin-top:34px;font-size: 16px;">{{__('minutes')}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-body">
            <div class="k-portlet__body">
                <div id="form-alert-message"></div>
                <div class="form-group row">

                    <div class="col-md-12">
                        <label>{{__(' Select Sensor')}}<span class="red-star">*</span></label>
                        {!! Form::select('sensor_id[]',array_column($sensors->toArray(),'name','id'),null,['class'=>'form-control select2','autocomplete'=>'off','multiple'=>'multiple']) !!}
                        <div class="invalid-feedback" id="permission_group_id-form-error"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-3 col-12 offset-md-9">
                    <button type="submit" class="btn btn-block  btn-dark-75 waves-effect">
                        {{ __('Submit')  }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
@section('footer')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $(".select2").select2();
        });
        '<a href="javascript:void(0);" onclick="$(this).closest(\'.added_images\').remove();" class="text-danger text-center form-control"> ' +
        '<i class="fa fa-trash"></i></a></div></div></div>'

        function onPlusImageClick() {

            $(".recipients").append('' +
                '<div class="col-md-12 added_images"><div class="row"><div class="col-md-6 form-group mb-3"> <span>Email/SMS</span> ' +
                ' <input type="email" class=" form-control form-control-rounded image" name="emails[]"> <div class="has-danger form-control-feedback "> ' +
                '</div>' +
                '<div class="has-danger form-control-feedback "></div></div> <div class="col-md-1 d-flex align-items-center justify-content-center"><a href="javascript:void(0);" onclick="$(this).closest(\'.added_images\').remove();" class="btn btn-icon btn-danger px-3 py-2"> ' +
                '<i class="fa fa-trash"></i></a></div>');

        }

        function submitMainForm() {
            formSubmit(
                '{{isset($result) ? route('system.staff.update',$result->id):route('system.staff.store')}}',
                $('#main-form').serialize(),
                function ($data) {
                    window.location = $data.data.url;
                },
                function ($data) {
                    $("html, body").animate({scrollTop: 0}, "fast");
                    pageAlert('#form-alert-message', 'error', $data.message);
                }
            );
        }

        function changeType() {
            var type = $('#type').val();
            if (type == 'Sensor is lost' || type == 'Low battery' || type == 'Open closed') {
                $(".hide_div").css('visibility', 'hidden');
            } else {
                $(".hide_div").css('visibility', 'visible');
            }
            if (type == 'Humidity') {
                $('.dgree_type').text('%')
            }
            if (type == 'Pressure') {
                $('.dgree_type').text('hPa')
            }
            if (type == 'Water usage') {
                $('.dgree_type').text('l/min')
            }
            if (type == 'Temperature') {
                $('.dgree_type').text('°C')
            }
            if (type == 'Differential pressure') {
                $('.dgree_type').text('Pa')
            }
            if (type == 'Electricity usage') {
                $('.dgree_type').text('W')
            }
            if (type == 'Pulse counter') {
                $('.dgree_type').text('')
            }
        }

        function sendType() {
            var send_type = $('#send_type').val();
            if (send_type == 'after') {
                $('.hide_time').show();
            }else {
                $('.hide_time').hide();
            }
        }
    </script>
@endsection
