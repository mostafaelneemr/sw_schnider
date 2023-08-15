@extends('system.layout')
@section('content')
    <!--begin::Row-->
    <div class="card card-custom gutter-b">

        <div class="card-body">

                {!! Form::open(['route' => isset($result) ? ['system.inventory.update',$result->id]:'system.inventory.store','files'=>true, 'method' => isset($result) ?  'PATCH' : 'POST','class'=> 'k-form','id'=> 'main-form','onsubmit'=> 'submitMainForm();return false;']) !!}
                    <div class="k-portlet__body">

                        <div id="form-alert-message"></div>



                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label>{{__('warehouse')}}<span class="red-star">*</span></label>
                                    {!! Form::select('warehouse_id',[''=>'Select']+$warehouse,isset($result) ? $result->warehouse_id : null,['class'=>'form-control','id'=>'warehouse_id-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="warehouse_id-form-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label>{{__('Name')}}<span class="red-star">*</span></label>
                                    {!! Form::text('name',isset($result) ? $result->name : null,['class'=>'form-control','id'=>'name-form-input','autocomplete'=>'off']) !!}
                                    <div class="invalid-feedback" id="name-form-error"></div>
                                </div>



                            </div>




                        <div class="form-group row">

                            <div class="col-md-6">
                                <label>{{__('inventory number')}}<span class="red-star">*</span></label>
                                {!! Form::text('inventory_number',isset($result) ? $result->inventory_number : null,['class'=>'form-control','id'=>'inventory_number-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="inventory_number-form-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label>{{__('storing category')}}<span class="red-star">*</span></label>
                                {!! Form::text('storing_category',isset($result) ? $result->storing_category : null,['class'=>'form-control','id'=>'storing_category-form-input','autocomplete'=>'off']) !!}
                                <div class="invalid-feedback" id="storing_category-form-error"></div>
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
                '{{isset($result) ? route('system.inventory.update',$result->id):route('system.inventory.store')}}',
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
