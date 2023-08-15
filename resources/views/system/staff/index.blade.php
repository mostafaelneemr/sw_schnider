@extends('system.layout')

@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')

    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">


            <!--begin: Datatable -->
            <table style="text-align: center;" class="table table-striped table-hover"
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
                sDom:'lrtip',
                ajax: '{!! url()->full() !!}?isDataTable=true',
                columns: [
                        @php $searchable = ['name','email']; @endphp
                        @foreach($js_columns as $key=> $row)
                        @if($key == 'action')
                    {
                        data: "{{$key}}", name: "{{$row}}", orderable: false, searchable: false
                    },
                        @else
                    {
                        data: "{{$key}}", name: "{{$row}}",searchable: Boolean("{{ (bool)in_array($key , $searchable)   }}")
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
