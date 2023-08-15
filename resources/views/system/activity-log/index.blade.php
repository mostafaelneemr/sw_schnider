@extends('system.layout')

@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="modal fade" id="filter-modal"  role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {!! Form::open(['id'=>'filterForm','onsubmit'=>'filterFunction($(this));return false;','class'=>'k-form']) !!}

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Filter')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="form-group mb1">
                        <label>{{__('Created At')}}</label>
                        <div class="input-daterange input-group" id="k_datepicker_5">
                            {!! Form::text('created_at1',null,['class'=>'form-control datepicker','autocomplete'=>'off']) !!}
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            {!! Form::text('created_at2',null,['class'=>'form-control datepicker','autocomplete'=>'off']) !!}
                        </div>
                        <span class="form-text text-muted">{{__('Linked pickers for date range selection')}}</span>

                    </div>


                    <div class="form-group row mb1">
                        <div class="col-md-6">
                            <label>{{__('ID')}}</label>
                            {!! Form::number('id',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('description',__('Status')) }}
                            {!! Form::select('status',[''=>__('Select Status'),'created'=>__('Created'),'updated'=>__('Updated'),'deleted'=>__('Deleted')],null,['class'=>'form-control','id'=>'description']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb1">


                        <div class="col-md-6">
                            {{ Form::label('subject_type',__('Model Type')) }}
                            {!! Form::text('subject_type',null,['class'=>'form-control','id'=>'subject_type','placeholder'=>'App\Models\Users']) !!}
                        </div>

                        <div class="col-md-6">
                            {{ Form::label('subject_id',__('Model ID')) }}
                            {!! Form::number('subject_id',null,['class'=>'form-control','id'=>'subject_id']) !!}
                        </div>

                    </div>


                    <div class="form-group row mb1">


                        <div class="col-md-6">
                            {{ Form::label('causer_type',__('User Type')) }}
                            {!! Form::text('causer_type',null,['class'=>'form-control','id'=>'causer_type','placeholder'=>'App\Models\Staff']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('causer_id',__('User ID')) }}
                            {!! Form::number('causer_id',null,['class'=>'form-control','id'=>'causer_id']) !!}

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

    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">


            <!--begin: Datatable -->
            <table style="text-align: center;" class="table table-striped table-hover" id="datatable-main">
                        <thead>
                        <tr>
                            @foreach($tableColumns as $key => $value)
                                <th>{{$value}}</th>
                            @endforeach
                        </tr>
                        </thead>

                    </table>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>

        <!-- end:: Content Body -->
    </div>
    <!-- end:: Content -->
@endsection
@section('footer')
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script type="text/javascript">
        $(function() {

            $datatable =   $('#datatable-main').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                sDom:'lrtip',
                ajax: '{!! url()->full() !!}?isDataTable=true',
                columns: [
                        @php $searchable = ['causer']; @endphp
                        @foreach($js_columns as $key=> $row)
                        @if($key == 'action')
                    { data: "{{$key}}", name: "{{$row}}",orderable: false,searchable: false},
                        @else
                    {
                        data: "{{$key}}", name: "{{$row}}",searchable: Boolean("{{ (bool)in_array($key , $searchable)   }}")
                    },
                    @endif
                    @endforeach
                ]

            });
        });
        function filterFunction($this,downloadExcel = false){

            if(downloadExcel == false) {
                $url = '{{url()->full()}}?&isDataTable=true&'+$this.serialize();
                $datatable.ajax.url($url).load();
                $('#filter-modal').modal('hide');
            }else{
                $url = '{{url()->full()}}?isDataTable=true&'+$this.serialize()+'&downloadExcel='+downloadExcel;
                window.location = $url;
            }

        }

    </script>

@endsection
