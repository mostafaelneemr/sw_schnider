@extends('system.layout')

@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet"
          type="text/css"/>

@endsection

@section('content')
    <!--begin::Row-->
    <div class="modal fade text-xs-left" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">{{__('Filter')}}</label>
                </div>
                {!! Form::open(['id'=>'filterForm','onsubmit'=>'filterFunction($(this));return false;']) !!}
                <div class="modal-body">

                    <div class="card-body">
                        <div class="card-block">
                            <div class="row">

                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        {{ Form::label('created_at1',__('Created From')) }}
                                        {!! Form::text('created_at1',null,['class'=>'form-control datepicker','id'=>'created_at1','style'=>'width:100%','autocomplete'=>'off']) !!}
                                    </fieldset>
                                </div>

                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        {{ Form::label('created_at2',__('Created To')) }}
                                        {!! Form::text('created_at2',null,['class'=>'form-control datepicker','style'=>'width:100%','autocomplete'=>'off']) !!}
                                    </fieldset>
                                </div>


                                {{--                            <div class="col-md-6">--}}
                                {{--                                <fieldset class="form-group">--}}
                                {{--                                    {{ Form::label('user_id',__('ID')) }}--}}
                                {{--                                    {!! Form::number('user_id',null,['class'=>'form-control','id'=>'user_id']) !!}--}}
                                {{--                                </fieldset>--}}
                                {{--                            </div>--}}

                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        {{ Form::label('serial_number',__('Serial Number')) }}
                                        {!! Form::text('serial_number',null,['class'=>'form-control','id'=>'serial_number']) !!}
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        {{ Form::label('name',__('Name')) }}
                                        {!! Form::text('name',null,['class'=>'form-control','id'=>'name']) !!}
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        {{ Form::label('location_id',__('Location:')) }}
                                        {!! Form::select('location_id',[__('Select Location')]+$locations,null,['class'=>'form-control']) !!}
                                    </fieldset>
                                </div>
                                {{--                            <div class="col-md-12">--}}
                                {{--                                <fieldset class="form-group">--}}
                                {{--                                    {{ Form::label('type',__('Type')) }}--}}
                                {{--                                    {!! Form::select('type[]',['temperature'=>'Temperature','pressure'=>'Pressure','pressure_diff'=>'Differential pressure','low_battery'=>'Low battery',--}}
                                {{--                        'humidity'=>'Humidity','open_closed'=>'Open closed','sensor_lost'=>'Sensor is lost','Water usage'=>'Water usage','Electricity usage'=>'Electricity usage','Pulse counter'=>'Pulse counter'--}}
                                {{--                ],null,['class'=>'form-control select2','style'=>'width:100%','multiple'=>'multiple']) !!}--}}
                                {{--                                </fieldset>--}}
                                {{--                            </div>--}}

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal" value="{{__('Close')}}">
                    <input type="submit" class="btn btn-outline-primary btn-md" value="{{__('Filter')}}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade text-xs-left" id="change-location-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <label class="modal-title text-text-bold-600" style="margin: 0 auto">{{__('Change Location')}}</label>
                </div>
                {!! Form::open(['id'=>'updateLocationForm']) !!}
                <div class="modal-body">

                    <div class="card-body">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        {{ Form::label('location_id',__('Location:')) }}
                                        {!! Form::select('location_id',[__('Select Location')]+$locations,null,['class'=>'form-control']) !!}
                                    </fieldset>
                                </div>
                                <input type="hidden" id="sensor_id" name="sensor_id">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal" value="{{__('Close')}}">
                    <input type="submit" class="btn btn-outline-primary btn-md" value="{{__('Filter')}}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="card card-custom gutter-b">

        <div class="card-body">

            <a  class="btn btn-bg-light"  style="color: #D4D5DF;background-color: #272935;" href="{{route('system.sensor.create')}}">Add Sensor <i class="fa fa-plus"></i></a>
            <a class="btn btn-bg-light " title="{{__('Filter')}}" href="javascript:;" data-toggle="modal" data-target="#filter-modal"  style="color: #D4D5DF;background-color: #272935;">
                Filters<i class="fas fa-filter"></i></a>

            <!--begin: Datatable -->
            <table style="text-align: center;" class="table table-striped table-hover fixTableHead"
                   id="datatable-main">
                <thead>
                <tr>
                @foreach($tableColumns as $key => $value)
                        <th>{{$value}}</th>
                    @endforeach
                </tr>
                </thead>
            </table>


        </div>

        <!-- end:: Content Body -->
    </div>
    <!-- end:: Content -->
@endsection
@section('footer')
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    {{--                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}


    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });

        function deleteSensor($routeName,$reload){

            if(!confirm("Do you want to delete this Sensor?")){
                return false;
            }
            addLoading();

            $.post(
                $routeName,
                {
                    '_method':'DELETE',
                    '_token':$('meta[name="csrf-token"]').attr('content')
                },
                function(response){
                    removeLoading();
                    if(isJSON(response)){
                        $data = response;
                        if($data.status == true){
                            toastr.success($data.message, 'Success !', {"closeButton": true});
                            $('#datatable-main').DataTable().ajax.reload();
                        }else{
                            toastr.error($data.message, 'Error !', {"closeButton": true});
                        }
                    }
                }
            )
        }

        $('#updateLocationForm').submit(function (e) {
            e.preventDefault();
            $("#btnSubmit").attr("disabled", true);
            var formData = new FormData(this);
            $.post('{{route('sensor.update-location')}}',$('#updateLocationForm').serialize(), function (out) {
                $('.validation_error_msg').remove();
                $('.product_row').css('border-color', '#aaa');
                if (out.status == false) {
                    toastr.error(out.msg, 'Error', {"closeButton": true});
                } else {
                    $('#change-location-modal').modal('hide');
                    $('#datatable-main').DataTable().ajax.reload();
                    toastr.success(out.msg, 'Success', {"closeButton": true});
                }
            }, 'json')


        });

        function changeSensorStatus($routeName,$reload){

            if(!confirm("Do you want to Change this ?")){
                return false;
            }

            if($reload == undefined){
                $reload = 3000;
            }

            $.post(
                $routeName,
                {
                    '_method':'POST',
                    '_token':$('meta[name="csrf-token"]').attr('content')
                },
                function(response){
                    console.log(response);
                    if(isJSON(response)){
                        $data = response;
                        if($data.status == true){
                            toastr.success($data.msg, 'Success !', {"closeButton": true});
                            $('#datatable-main').DataTable().ajax.reload();
                        }else{
                            toastr.error($data.msg, 'Error !', {"closeButton": true});
                        }
                    }
                }
            )
        }

    </script>
    <script type="text/javascript">

        $(function () {

            $datatable = $('#datatable-main').DataTable({
                processing: true,
                serverSide: true,
                "bLengthChange": false,
                sDom:'lrtip',
                ajax: '{!! request()->fullUrlWithQuery(["isDataTable" => true]) !!}',
                columns: [
                    @php $searchable = ['name' , 'location_name']; @endphp
                        @foreach($js_columns as $key=> $row)
                        @if($key == 'action')
                    {
                        data: "{{$key}}", name: "{{$row}}", orderable: false, searchable:false
                    },
                        @else
                    {
                        data: "{{$key}}", name: "{{$row}}",searchable: Boolean("{{ (bool)in_array($key , $searchable)   }}")
                    },
                    @endif
                    @endforeach
                ]

            });

            $datatable.on('draw.dt' , function(){
                $('[data-toggle="tooltip"]').tooltip()
            })
        });

        function filterFunction($this, downloadExcel = false) {
            if (downloadExcel == false) {
                $url = '{{url()->full()}}?&isDataTable=true&' + $this.serialize();
                $datatable.ajax.url($url).load();
                $('#filter-modal').modal('hide');
            } else {
                $url = '{{url()->full()}}?isDataTable=true&' + $this.serialize() + '&downloadExcel=' + downloadExcel;
                window.location = $url;
            }

        }

        $('#change-location-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var location_id = button.data('location_id');
            $('#location_id').val(location_id);
            var sensor_id = button.data('sensor_id');
            $('#sensor_id').val(sensor_id);
        });

    </script>

@endsection
