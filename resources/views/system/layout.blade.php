<!DOCTYPE html>

<html @if(lang() == 'en') lang="en" direction="ltr" @else lang="ar" direction="rtl" style="direction: rtl;" @endif>
@php
    $logo = url('storage/app/'.setting('image'));
@endphp
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>{{ucfirst(request()->route()->getActionMethod())}} - {{setting('company_name')}}</title>

    <meta name="description" content="{{setting('company_name')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ajax-post" content="{{route('system.ajax.post')}}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/css/dataTables.fontAwesome.css')}}">
    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('public/assets/plugins/custom/fullcalendar/fullcalendar.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />

    <!--end::Page Vendors Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('public/assets/plugins/global/plugins.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/plugins/custom/prismjs/prismjs.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/css/style.bundle'.direction().'.css')}}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('public/assets/css/themes/layout/header/base/light'.direction().'.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/css/themes/layout/header/menu/light'.direction().'.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/css/themes/layout/brand/light'.direction().'.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/css/themes/layout/aside/light'.direction().'.css')}}" rel="stylesheet" type="text/css" />

    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{$logo}}" />
    <script type="application/javascript">
        var $global_lang ='{{lang()}}';
    </script>
    <style>

        .red-star{
            color:red;
        }
        .dataTables_wrapper{
            overflow-y: auto;
        }

        table thead{
            position: sticky;
            top: 0;
            left: 0;
            background: white;
        }



        .aside-menu .menu-nav > .menu-item > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item > .menu-link .menu-text{
            font-weight: 800;
            font-size: 14px;
        }

        .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-link .menu-text{
            color: white;
        }
        .aside-menu .menu-nav .menu-item menu-item-submenu:hover{
            color: white;
        }
        .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-heading, .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-link{
            background-color: #1b1b28;
        }



        .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-heading .menu-arrow, .aside-menu .menu-nav > .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-link .menu-arrow {
            color: white;
        }

        .aside-menu .menu-nav > .menu-item > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item > .menu-link .menu-text {
            color: #a2a3b7;
        }
        .aside {
            background-color: #1e1e2d;
        }
        .brand .btn .svg-icon svg g [fill]{
            fill: #a2a3b7;
        }
        .aside-menu {
            background-color: #1e1e2d;
        }

        .brand {
            background-color: #1a1a27;


        }







        .aside-menu .menu-nav .menu-item .menu-link i{
            color: white;
        }

        .menu-nav .menu-item:hover .menu-icon i, .menu-nav .menu-item.menu-item-open .menu-icon i,.menu-nav .menu-item .active .menu-icon i
        {
            color: white !important;
        }


        .aside-menu .menu-nav > .menu-item > .menu-heading .menu-arrow, .aside-menu .menu-nav > .menu-item > .menu-link .menu-arrow{
            color: white;
        }

        .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-link .menu-text{
            color: white;
        }

        .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-heading, .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-link {
            background-color: #a2a3b7;
        }

        /*.aside-menu .menu-nav > .menu-item > .menu-heading i:hover, .aside-menu .menu-nav > .menu-item > .menu-link i:hover {*/
        /*    color: #a22826;*/
        /*}*/



        .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-link .menu-text {
            color: white;
        }

        .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-heading .menu-arrow, .aside-menu .menu-nav > .menu-item.menu-item-open > .menu-link .menu-arrow {
            color: white;
        }

        .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-link .menu-text {
            color: white;
        }
        .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-heading .menu-bullet.menu-bullet-dot > span, .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover > .menu-link .menu-bullet.menu-bullet-dot > span {
            background-color: white;
        }

        .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item > .menu-heading .menu-text, .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item > .menu-link .menu-text{
            color: white;
        }
        .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item > .menu-heading .menu-bullet.menu-bullet-dot > span, .aside-menu .menu-nav > .menu-item .menu-submenu .menu-item > .menu-link .menu-bullet.menu-bullet-dot > span {
            background-color: #a2a3b7;
        }



    </style>

@if(lang() == 'en')


@else


    <style>
        @import url(//fonts.googleapis.com/earlyaccess/droidarabickufi.css);
        body{
            font-family: 'Cairo', sans-serif !important;
        }
        th{
            font-weight: bold !important;
        }
    </style>

    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">


    <style>


        .color-red {
            color: red !important;
        }

         .tree-item-head .dropdown {
        opacity: 0;
    }

    .tree-item-head i {
        cursor: pointer;
    }

    .tree-item-head:hover {
        background-color: rgba(0, 0, 0, .05);
    }

    .tree-item-head:hover .dropdown {
        opacity: 1;
    }

    .tree-item .tree-item-child {
        padding-left: 15px;
    }
        @if(app()->getLocale() =='ar')
            .content-body{
            width: 124% !important;
        }
        @endif

    </style>
    @yield('header')

</head>
<!--end::Head-->

<body @if(request('without_navbar') == 'true')  @else class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-minimize-hoverable page-loading" @endif id="kt_body" >

@php
    $auth = \Illuminate\Support\Facades\Auth::user();
@endphp




<!--begin::Main-->

@include('system.partials.mobile-header')
<div class="d-flex flex-column flex-root">

    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">

    @include('system.partials.aside')
    <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

        @include('system.partials.header')
        <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            @include('system.partials.sub-header')
                {{--@include('system.partials.sub-header')--}}
                <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">

                        <!--begin::Container-->
                        <div class="container-fluid">

                @yield('content')
                            <div class="modal fade text-xs-left" id="modal-iframe" role="dialog" aria-labelledby="myModalLabe"
                                 aria-hidden="true">
                                <div class="modal-dialog" id="modal-iframe-width" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="card-block">
                                                    <div class="row" style="text-align: center;">
                                                        {{--<img id="modal-iframe-image" src="{{asset('assets/system/loading.gif')}}">--}}
                                                        <iframe id="modal-iframe-url" style="display: none;" src=""></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div></div>

            </div>

            <!--end::Content-->

            @include('system.partials.footer')
        </div>

        <!--end::Wrapper-->
    </div>

    <!--end::Page-->
</div>

<!--end::Main-->


<!-- begin::Notifications Panel-->
{{--<div id="kt_quick_notifications" class="offcanvas offcanvas-right p-10">--}}

{{--    <!--begin::Header-->--}}
{{--    <div class="offcanvas-header d-flex align-items-center justify-content-between mb-10">--}}
{{--        <h3 class="font-weight-bold m-0">{{__('Notifications')}}--}}
{{--            <small class="text-muted font-size-sm ml-2"><span class="notify_count"></span> {{__('New')}}</small>--}}
{{--        </h3>--}}
{{--        <a href="#" onclick="make_as_read()" title="Make all as readed" class="btn btn-xs btn-icon btn-light btn-hover-primary" >--}}
{{--            <i class="fa fa-check icon-xs text-success"></i>--}}

{{--        </a>--}}
{{--    </div>--}}

{{--    <!--end::Header-->--}}

{{--    <!--begin::Content-->--}}
{{--    <div class="offcanvas-content pr-5 mr-n5">--}}

{{--        <!--begin::Nav-->--}}
{{--        <div class="navi navi-icon-circle navi-spacer-x-0" id="notify_data">--}}






{{--        </div>--}}

{{--        <!--end::Nav-->--}}
{{--    </div>--}}

{{--    <!--end::Content-->--}}
{{--</div>--}}

<!-- end::Notifications Panel-->
@include('system.partials.quick-actions')

<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">

    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{__('User Profile')}}
        </h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>

    <!--end::Header-->

    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">

        <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('{{asset('default.jpg')}}')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{$auth->Fullname}}</a>
                 <div class="navi mt-2">
                    <a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">

											<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>

                                            <!--end::Svg Icon-->
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary">{{$auth->email}}</span>
								</span>
                    </a>
                    <a href="{{route('logout')}}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">{{__('Sign Out')}}</a>
                 </div>
            </div>
        </div>

        <!--end::Header-->

        <div>




        </div>

<hr>
        <div class="tree"></div>

        <!--end::Notifications-->
    </div>

    <!--end::Content-->
</div>

<!-- end::User Panel-->



<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">

				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>

                <!--end::Svg Icon-->
			</span>
</div>

<!--end::Scrolltop-->
<!--[html-partial:include:{"file":"partials/_extras/toolbar.html"}]/-->

<!--[html-partial:include:{"file":"partials/_extras/offcanvas/demo-panel.html"}]/-->









{{-- start abdo edit --}}






{{--<script>--}}
{{--    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";--}}
{{--</script>--}}

<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>

<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('public/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('public/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('public/assets/plugins/custom/tree/tree.js')}}"></script>
<script src="{{asset('public/assets/js/scripts.bundle.js')}}"></script>

<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>

<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('public/assets/js/pages/widgets.js')}}"></script>
<script src="{{asset('public/assets/js/node.js')}}" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script>
    @php
        $success = session('success');
        $add= session('add');
        $created= session('created');
        $updated = session('updated');
        $deleted = session('deleted');
        $delete = session('delete');
        $err = session('error');
    @endphp

    @if (isset($success))
    Swal.fire({
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($created))
    Swal.fire({
        icon: "success",
        title: "{{ session('created') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($add))
    Swal.fire({
        icon: "success",
        title: "{{ session('add') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($updated))
    Swal.fire({
        icon: "info",
        title: "{{session('updated') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($deleted))
    Swal.fire({
        icon: "success",
        title: "{{ session('deleted') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($delete))
    Swal.fire({
        icon: "success",
        title: "{{ session('delete') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif
    @if (isset($err))
    Swal.fire({
        icon: "error",
        title: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 3000
    });
    @endif


</script>

<script>
    $(function () {

        $('.tree').tree({
               getLocations : "{{ route('system.locations') }}",
               saveLocations: "{{ route('system.locations-action') }}",
               href : "{{ route('system.dashboard') }}"
        });

        setTimeout(function(){
            $('table').each(function(i , el ){

            $(el).find('thead th').each(  function(index)  {
        var title = $(this).text();
        if(!$.fn.dataTable) return;
        var searchable = $.fn.dataTable.tables({ visible: true, api: true }).settings()[0].aoColumns[index].bSearchable;

        if(!searchable) return;

        $(this).html( `<div class="input-icon input-icon-right search_header">
            <p style="visibility:hidden" class="h">${title}</p>
            <input type="text" class="form-control column_search" placeholder="${title}">
                    <span>
                    <i class="flaticon2-search-1 icon-md"></i>
            </span>
            </div>`);

        $(this).find('.search_header').css('width' , $(this).find(".h").width() + 50);

                $(this).find(".h").addClass('d-none');
       });

       $( '.column_search'  ).on( 'keyup',function () {

        $.fn.dataTable.tables({ visible: true, api: true })
       .column( $(this).parent().index() )
       .search( this.value )
       .draw();
});
       $( '.search_header'  ).on( 'click',function (e) {
   e.stopPropagation();
   $(this).find('input').focus();
});

        })
        } , 1000);


    });

    function notify(message,type='info') {
        $.notify(message,type);
    }






        $(document).ready(function () {
        // check_notify();
    //     setInterval(function(){
    //     check_notify();
    //
    // }, 10000);
    })

        function make_as_read() {
        $.get("{{route('system.ajax.post')}}?type=make_as_read",function () {
            check_notify();
        });
    }

        function playSound(url) {
        const audio = new Audio('{{asset('public/notification.mp3')}}');
        audio.play();
    }

        function check_notify() {
        $.get("{{route('system.ajax.post')}}?type=check_notify",function (data) {

            if(data.status == true){
                if(data.number > 0) {
                    $('.link_notify_number').html('<span class="label chat_number  label-danger">' + data.number + '</span>')
                    $('.notify_count').html(data.number)
                    playSound();
                    toastr.error(data.number +' New Alarms', 'Alarm !', {"closeButton": true});
                }else{
                    $('.link_notify_number').html('')
                    $('.notify_count').html(data.number)
                }
                $('#notify_data').html('');
                for (let i = 0; i < data.notify.length; i++) {
                    var row = data.notify[i];

                    // skip loop if the property is from prototype
                    if(row.read_at == '' || row.read_at == null){
                        var bill = 'text-primary';
                    }else{
                        var bill = 'text-muted';
                    }

                    var one  = ' <a href="'+row.data.url+'" class="navi-item">\n' +
                        '                <div class="navi-link rounded">\n' +
                        '                    <div class="symbol symbol-50 symbol-circle mr-3">\n' +
                        '                        <div class="symbol-label">\n' +
                        '                            <i class="flaticon-bell '+bill+' icon-lg"></i>\n' +
                        '                        </div>\n' +
                        '                    </div>\n' +
                        '                    <div class="navi-text">\n' +
                        '                        <div class="font-weight-bold font-size-lg">'+row.data.title+'</div>\n' +
                        '                        <div title="'+row.created_at+'" class="text-muted">'+timeSince(new Date(row.created_at))+'</div>\n' +
                        '                    </div>\n' +
                        '                </div>\n' +
                        '            </a>';
                    $('#notify_data').append(one);
                }
            }
        })
    }
        function timeSince(date) {

        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = seconds / 31536000;

        if (interval > 1) {
        return Math.floor(interval) + " years";
    }
        interval = seconds / 2592000;
        if (interval > 1) {
        return Math.floor(interval) + " months";
    }
        interval = seconds / 86400;
        if (interval > 1) {
        return Math.floor(interval) + " days";
    }
        interval = seconds / 3600;
        if (interval > 1) {
        return Math.floor(interval) + " hours";
    }
        interval = seconds / 60;
        if (interval > 1) {
        return Math.floor(interval) + " minutes";
    }
        return Math.floor(seconds) + " seconds";
    }


</script>


@yield('footer')
@stack('js')
<!--end::Page Scripts-->
</body>

<!--end::Body-->
</html>
