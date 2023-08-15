@extends('system.layout')

@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">


            <!--begin: Datatable -->
            <table style="text-align: center;" class="table table-bordered table-hover table-checkable" id="datatable-main">
                    <thead>
                    <tr>
                        @foreach($tableColumns as $key => $value)
                            <th>{{$value}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        @foreach($tableColumns as $key => $value)
                            <th>{{$value}}</th>
                        @endforeach
                    </tr>
                    </tfoot>
                </table>

                <!--end: Datatable -->
            </div>
        </div>

@endsection
@section('footer')
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        $(function() {



            $datatable =   $('#datatable-main').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url()->full() !!}?isDataTable=true',
                columns: [
                        @foreach($js_columns as $key=> $row)
                        @if($key == 'action')
                    { data: "{{$key}}", name: "{{$row}}",orderable: false,searchable: false},
                        @else
                    { data: "{{$key}}", name: "{{$row}}"},
                    @endif
                    @endforeach
                ]

            });
        });


    </script>
@endsection
