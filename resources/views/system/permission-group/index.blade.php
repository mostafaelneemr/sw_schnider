@extends('system.layout')
@section('header')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
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

@endsection
@section('footer')
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

         $(function() {

             $datatable =   $('#datatable-main').DataTable({
                 processing: true,
                 serverSide: true,
                 sDom:'lrtip',
                 ajax: '{!! url()->full() !!}?isDataTable=true',
                 columns: [
                         @php $searchable = []; @endphp
                         @foreach($js_columns as $key=> $row)
                         @if($key == 'action' || $key == 'count')
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


    </script>
@endsection
