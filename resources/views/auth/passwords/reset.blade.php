
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Metronic | Login Page 1</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="{{asset('public/assets/css/pages/login/login-1.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('public/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" style="background-image: url(assets/media/bg/bg-10.jpg)" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-row-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-row-auto px-lg-0 px-5 pb-sm-40 pb-lg-40 flex-grow-1" style="background-repeat:no-repeat;background-position: bottom;background-image: url(assets/media/svg/illustrations/login-visual-1.svg)">
            <!--begin::Aside Container-->
            <div class="d-flex flex-row-fluid flex-column mt-lg-30 mb-lg-0 pb-lg-0 mb-20 pb-40 mt-0 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-10">
                    <img src="{{asset('public/assets/media/logos/logo-letter-1.png')}}" class="max-h-70px" alt="" />
                </a>
                <!--end::Aside header-->
                <!--begin::Aside title-->
                <h3 class="font-weight-bolder text-center display5 pb-lg-0 pb-40">
                </h3>
                <!--end::Aside title-->
            </div>
            <!--end::Aside Container-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative  p-7 ml-auto mr-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center mt-6 mt-lg-0">

                <!--begin::Forgot-->
                <div class="kt-login__body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                @endif

                <!--begin::Form-->
                        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        <!--begin::Title-->
                        {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                        <div class="text-center pt-lg-40 mt-lg-20 pb-15">
                            @if ($errors->any())


                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                            @endif
                            <h3 class="font-weight-bolder text-dark display5">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">

                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="text" placeholder="Email" name="email" autocomplete="off" value="{{ $email  }}" required autofocus />
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off" required  />
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Password Confirmation" name="password_confirmation" autocomplete="off" required  />
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                        <div class="form-group d-flex flex-wrap flex-center pb-lg-0">
                            <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Reset Password</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>

        </div>
        <!--end::Content-->
    </div>

</div>


<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>

<script src="{{asset('public/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('public/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('public/assets/js/scripts.bundle.js')}}"></script>

<script src="{{asset('public/assets/js/pages/custom/login/login.js')}}"></script>

</body>

</html>