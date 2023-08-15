@extends('system.layout')

@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')

    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">

            <a class="btn btn-bg-light" style="color: #D4D5DF;background-color: #272935;"
               href="{{route('system.rules-notifications.create')}}">Create new rule <i class="fa fa-plus"></i></a>
            <a class="btn btn-bg-light" style="color: #D4D5DF;background-color: #272935;"
               href="{{route('system.rules-notifications.create')}}">Export rule list <i
                    class="fa fa-file-excel"></i></a>
            <!--begin: Datatable -->
            <table style="text-align: center;" class="table table-bordered table-hover table-checkable"
                   id="datatable-main">
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


        </div>

        <!-- end:: Content Body -->
    </div>
    <!-- end:: Content -->
@endsection
@section('footer')
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('public/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script type="text/javascript">

        $(function () {


            $datatable = $('#datatable-main').DataTable({
                processing: true,
                serverSide: true,
                "bLengthChange": false,
                ajax: '{!! url()->full() !!}?isDataTable=true',
                columns: [
                        @foreach($js_columns as $key=> $row)
                        @if($key == 'action')
                    {
                        data: "{{$key}}", name: "{{$row}}", orderable: false, searchable: false
                    },
                        @else
                    {
                        data: "{{$key}}", name: "{{$row}}"
                    },
                    @endif
                    @endforeach
                ]

            });
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

    </script>
@endsection
