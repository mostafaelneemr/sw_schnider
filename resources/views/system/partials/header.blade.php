
@php
$auth = \Illuminate\Support\Facades\Auth::user();
@endphp
<!--begin::Header-->

					<div id="kt_header" class="header header-fixed">

						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">

							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

								<!--begin::Header Menu-->


								<!--end::Header Menu-->
							</div>

							<!--end::Header Menu Wrapper-->

							<!--begin::Topbar-->
							<div class="topbar">

{{--                                <div class="topbar-item">--}}
{{--                                    <div class="btn btn-icon btn-icon-mobile btn-clean btn-lg mr-1 pulse pulse-primary" id="kt_quick_notifications_toggle">--}}
{{--										<span class="svg-icon svg-icon-xl svg-icon-primary">--}}

{{--											<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->--}}
{{--											<i class="flaticon-bell text-primary icon-lg"></i>--}}

{{--                                            <!--end::Svg Icon-->--}}
{{--										</span>--}}
{{--                                        <span class="link_notify_number"></span>--}}
{{--                                        <span class="pulse-ring"></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

								<!--begin::User-->
								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{$auth->name}}</span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">{{strtoupper(substr($auth->name,0,1))}}</span>
										</span>
									</div>
								</div>

								<!--end::User-->
							</div>

							<!--end::Topbar-->
						</div>

						<!--end::Container-->
					</div>

					<!--end::Header-->
