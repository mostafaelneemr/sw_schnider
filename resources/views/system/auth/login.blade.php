<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5FS8GGP');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8" />
    <title>تسجيل دخول </title>
    <meta name="description" content="Singin page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{asset('public/assets/css/pages/login/login-4.css?v=7.1.5')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
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
    <link rel="shortcut icon" href="{{asset('logo/logo.jpg')}}" />
    <!-- Hotjar Tracking Code for keenthemes.com -->
    <script>(function(h,o,t,j,a,r){ h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)}; h._hjSettings={hjid:1070954,hjsv:6}; a=o.getElementsByTagName('head')[0]; r=o.createElement('script');r.async=1; r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv; a.appendChild(r); })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Content-->
        <div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white">
            <!--begin::Wrapper-->
            <div class="col-7"  style="height: 100%;
                background-size: cover;background-image: url('{{asset("public/assets/media/misc/bg_icon.svg")}}');">

            </div>
            <div class="col-5">
                <!--begin::Logo-->
                <p style="text-align: center;">
                <a href="#" class="login-logo pb-xl-20 pb-15" >
                    <img src="{{asset('logo/logo.jpg')}}"  style="width: 60%" alt="" />
                </a>
                </p>
                <!--end::Logo-->
                <!--begin::Signin-->
                <div class="login-form">
                    <!--begin::Form-->

                        <form  class="form" action="{{url('system/login')}}" id="kt_login_singin_form"  method="post" autocomplete="off">
                            {{ csrf_field() }}
                            @if($errors->any())
                                <div class="alert alert-custom alert-danger fade show mb-5" style="    text-align: center;font-size: 15px;" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">{{__('E-mail or password is invalid')}}</div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            @endif


                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">{{__('Your Email')}}</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"  type="email" placeholder="{{__('E-mail')}}" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">{{__('Password')}}</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"  type="password" placeholder="{{__('Password')}}" name="password"  autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{__('Sign In')}}</button>
                            <a href="{{route('password.request')}}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>

                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>

            <!--end::Wrapper-->
        </div>
        <!--begin::Content-->
        <!--begin::Aside-->

        <!--end::Aside-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var HOST_URL = "/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('public/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('public/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('public/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('public/assets/js/pages/custom/login/login-4.js?v=7.1.5')}}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>

