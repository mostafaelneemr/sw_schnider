<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

<!--begin::Info-->
<div class="d-flex align-items-center flex-wrap mr-2">
<div class="d-flex align-items-center flex-wrap mr-1">
<!--begin::Page Heading-->
<div class="d-flex align-items-baseline mr-5">
    @if(isset($pageTitle))
    <!--begin::Page Title-->
    <h5 class="text-dark font-weight-bold my-2 mr-5">{{$pageTitle}}</h5>
    <!--end::Page Title-->
    @endif

{{--    @if(isset($breadcrumb))--}}
{{--        <!--begin::Breadcrumb-->--}}
{{--            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">--}}
{{--                @foreach($breadcrumb as $value)--}}
{{--                    <li class="breadcrumb-item @if(!isset($value['url'])) active @endif">--}}
{{--                        @if(isset($value['url']))--}}
{{--                            <a href="{{$value['url']}}" class="text-muted">--}}
{{--                                {{$value['text']}}--}}
{{--                            </a>--}}
{{--                        @else--}}
{{--                            {{$value['text']}}--}}
{{--                        @endif--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--            <!--end::Breadcrumb-->--}}
{{--@endif--}}


</div>
<!--end::Page Heading-->
</div>

<!--begin::Action-->



<!--end::Action-->
</div>

<!--end::Info-->

<!--begin::Toolbar-->
<div class="d-flex align-items-center flex-wrap">
@if(isset($add_new))
    <a href="{{route($add_new['route'])}}" class="btn btn-icon btn-outline-primary mr-2">
        <i class="fas fa-plus"></i>
    </a>
@endif

@if(isset($filter))
    <a title="{{__('Filter')}}" href="javascript:;" data-toggle="modal" data-target="#filter-modal"   class="btn btn-icon btn-outline-primary mr-2">
        <i class="fas fa-filter"></i></a>
@endif

@if(isset($download_excel))
        <a title="{{__('Download Excel')}}" href="javascript:;" onclick="filterFunction($('#filterForm'),true)" class="btn btn-icon btn-outline-primary mr-2">
        <i class="flaticon-download-1"></i></a>
@endif
@yield('sub-header-buttons')

<!--begin::Actions-->
{{--									<a href="#" class="btn btn-bg-white btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0">--}}
{{--										<i class="flaticon2-file icon-md"></i>--}}
{{--									</a>--}}
{{--									<a href="#" class="btn btn-bg-white btn-icon-danger btn-hover-primary btn-icon mr-3 my-2 my-lg-0">--}}
{{--										<i class="flaticon-download-1 icon-md"></i>--}}
{{--									</a>--}}
{{--									<a href="#" class="btn btn-bg-white btn-icon-success btn-hover-primary btn-icon mr-3 my-2 my-lg-0">--}}
{{--										<i class="flaticon2-fax icon-md"></i>--}}
{{--									</a>--}}
{{--									<a href="#" class="btn btn-bg-white btn-icon-warning btn-hover-primary btn-icon mr-3 my-2 my-lg-0">--}}
{{--										<i class="flaticon2-settings icon-md"></i>--}}
{{--									</a>--}}

<!--end::Actions-->

<!--begin::Dropdown-->
{{--									<div class="dropdown dropdown-inline my-2 my-lg-0" data-toggle="tooltip" title="Quick actions" data-placement="left">--}}
{{--										<a href="#" class="btn btn-primary btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--											<span class="svg-icon svg-icon-md">--}}

{{--												<!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-2.svg-->--}}
{{--												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--														<rect x="0" y="0" width="24" height="24" />--}}
{{--														<path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000" />--}}
{{--													</g>--}}
{{--												</svg>--}}

{{--												<!--end::Svg Icon-->--}}
{{--											</span>--}}
{{--										</a>--}}
{{--										<div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">--}}

{{--											<!--[html-partial:begin:{"id":"demo1/dist/inc/view/partials/content/dropdowns/dropdown-1","page":"index"}]/-->--}}

{{--											<!--begin::Navigation-->--}}
{{--											<ul class="navi navi-hover">--}}
{{--												<li class="navi-header font-weight-bold py-4">--}}
{{--													<span class="font-size-lg">Choose Label:</span>--}}
{{--													<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>--}}
{{--												</li>--}}
{{--												<li class="navi-separator mb-3 opacity-70"></li>--}}
{{--												<li class="navi-item">--}}
{{--													<a href="#" class="navi-link">--}}
{{--														<span class="navi-text">--}}
{{--															<span class="label label-xl label-inline label-light-success">Customer</span>--}}
{{--														</span>--}}
{{--													</a>--}}
{{--												</li>--}}
{{--												<li class="navi-item">--}}
{{--													<a href="#" class="navi-link">--}}
{{--														<span class="navi-text">--}}
{{--															<span class="label label-xl label-inline label-light-danger">Partner</span>--}}
{{--														</span>--}}
{{--													</a>--}}
{{--												</li>--}}
{{--												<li class="navi-item">--}}
{{--													<a href="#" class="navi-link">--}}
{{--														<span class="navi-text">--}}
{{--															<span class="label label-xl label-inline label-light-warning">Suplier</span>--}}
{{--														</span>--}}
{{--													</a>--}}
{{--												</li>--}}
{{--												<li class="navi-item">--}}
{{--													<a href="#" class="navi-link">--}}
{{--														<span class="navi-text">--}}
{{--															<span class="label label-xl label-inline label-light-primary">Member</span>--}}
{{--														</span>--}}
{{--													</a>--}}
{{--												</li>--}}
{{--												<li class="navi-item">--}}
{{--													<a href="#" class="navi-link">--}}
{{--														<span class="navi-text">--}}
{{--															<span class="label label-xl label-inline label-light-dark">Staff</span>--}}
{{--														</span>--}}
{{--													</a>--}}
{{--												</li>--}}
{{--												<li class="navi-separator mt-3 opacity-70"></li>--}}
{{--												<li class="navi-footer py-4">--}}
{{--													<a class="btn btn-clean font-weight-bold btn-sm" href="#">--}}
{{--														<i class="ki ki-plus icon-sm"></i>Add new</a>--}}
{{--												</li>--}}
{{--											</ul>--}}

{{--											<!--end::Navigation-->--}}

{{--											<!--[html-partial:end:{"id":"demo1/dist/inc/view/partials/content/dropdowns/dropdown-1","page":"index"}]/-->--}}
{{--										</div>--}}
{{--									</div>--}}

<!--end::Dropdown-->
</div>

<!--end::Toolbar-->
</div>
</div>

<!--end::Subheader-->
