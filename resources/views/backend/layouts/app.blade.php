<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100"
    @if (app_setting()->rtl_ltr == 1) dir="ltr" @else dir="rtl" @endif>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="floating_number" content="{{ app_setting()->floating_number }}" />
    <meta name="negative_amount_symbol" content="{{ app_setting()->negative_amount_symbol }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sales ERP Software">
    <meta name="author" content="Bdtask">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="get-localization-strings" content="{{ route('get-localization-strings') }}">
    <meta name="default-localization" content="{{ app_setting()->lang?->value }}">
    <title>@yield('title')</title>
    <!-- App favicon -->

    <link rel="shortcut icon" class="favicon_show" href="{{ app_setting()->favicon }}">
    @include('backend.layouts.assets.css')
    @stack('css')
</head>

<body class="fixed sidebar-mini @yield('body-class')">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>{{ localize('please_wait') }}</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <div class="wrapper">
        @include('backend.layouts.sidebar')
        <!-- Page Content  -->
        <div class="content-wrapper">
            <div class="main-content">
                <!--Navbar-->
                <nav class="navbar-custom-menu navbar navbar-expand-xl m-0">
                    <div class="sidebar-toggle-icon" id="sidebarCollapse">sidebar toggle<span></span></div>
                    <!--/.sidebar toggle icon-->
                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Toggler -->
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbar-collapse" aria-expanded="true"
                            aria-label="Toggle navigation"><span></span> <span></span></button>
                        <div class="d-flex align-items-center justify-content-between w-100 flex-wrap gap-2 me-xl-3">
                            <a class="nav-link cache-btn ms-xl-3 d-inline-flex" href="{{ route('all_clear') }}">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                        viewBox="0 0 26 26" fill="none">
                                        <path
                                            d="M0.925 13.0005C0.925 19.6585 6.342 25.075 13.0005 25.075C13.3074 25.075 13.5555 24.8263 13.5555 24.52C13.5555 24.2136 13.3074 23.965 13.0005 23.965C6.95381 23.965 2.03504 19.0462 2.03504 13.0005C2.03504 6.9543 6.95382 2.03504 13.0005 2.03504C19.0467 2.03504 23.965 6.95429 23.965 13.0005C23.965 13.3068 24.2131 13.5555 24.52 13.5555C24.8269 13.5555 25.075 13.3068 25.075 13.0005C25.075 6.342 19.6585 0.925 13.0005 0.925C6.34199 0.925 0.925 6.34199 0.925 13.0005Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                        <path
                                            d="M7.24125 20.2744H18.7607C19.0677 20.2744 19.3158 20.0257 19.3158 19.7194V12.0386C19.3158 11.7323 19.0677 11.4836 18.7607 11.4836H7.24125C6.93433 11.4836 6.68623 11.7323 6.68623 12.0386V19.7194C6.68623 20.0257 6.93433 20.2744 7.24125 20.2744ZM18.2057 12.5936V19.1644H7.79627V12.5936H18.2057Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                        <path
                                            d="M12.4465 19.7194C12.4465 20.0258 12.6946 20.2745 13.0015 20.2745C13.3084 20.2745 13.5565 20.0258 13.5565 19.7194V17.7994C13.5565 17.493 13.3084 17.2443 13.0015 17.2443C12.6946 17.2443 12.4465 17.493 12.4465 17.7994V19.7194Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                        <path
                                            d="M15.3247 19.7193C15.3247 20.0257 15.5728 20.2744 15.8797 20.2744C16.1866 20.2744 16.4347 20.0257 16.4347 19.7193V15.8792C16.4347 15.5728 16.1866 15.3242 15.8797 15.3242C15.5728 15.3242 15.3247 15.5728 15.3247 15.8792V19.7193Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                        <path
                                            d="M9.56672 19.7184C9.56672 20.0248 9.81482 20.2735 10.1217 20.2735C10.4287 20.2735 10.6768 20.0248 10.6768 19.7184V13.9606C10.6768 13.6543 10.4287 13.4056 10.1217 13.4056C9.81482 13.4056 9.56672 13.6543 9.56672 13.9606V19.7184Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                        <path
                                            d="M7.24027 12.5934H18.7607C19.0677 12.5934 19.3158 12.3448 19.3158 12.0384V11.0784C19.3158 10.243 18.6366 9.5638 17.8017 9.5638H14.5146V5.31959C14.5146 4.48465 13.8349 3.80549 12.9995 3.80549C12.1651 3.80549 11.4859 4.48471 11.4859 5.31959V9.5638H8.19935C7.36444 9.5638 6.68525 10.243 6.68525 11.0784V12.0384C6.68525 12.3448 6.93335 12.5934 7.24027 12.5934ZM18.2057 11.0784V11.4834H7.79529V11.0784C7.79529 10.8552 7.97638 10.6738 8.19935 10.6738H12.0409C12.3479 10.6738 12.596 10.4252 12.596 10.1188V5.31959C12.596 5.0969 12.7771 4.91553 12.9995 4.91553C13.2232 4.91553 13.4046 5.0971 13.4046 5.31959V10.1188C13.4046 10.4252 13.6527 10.6738 13.9596 10.6738H17.8017C18.0246 10.6738 18.2057 10.8552 18.2057 11.0784Z"
                                            fill="#188753" stroke="#188753" stroke-width="0.15" />
                                    </svg>
                                </span>{{ localize('cache_clear') }}
                            </a>
                        </div>
                    </div>
                    <div class="navbar-icon d-flex">
                        <ul class="navbar-nav flex-row gap-3 align-items-center">
                            <!--/.dropdown-->
                            <li class="nav-item d-none d-md-block">
                                <a href="#" id="btnFullscreen">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42"
                                        viewBox="0 0 48 48" fill="none">
                                        <circle cx="24" cy="24" r="24" fill="#F8FAF8" />
                                        <path
                                            d="M33.4394 14H30.9024C30.5927 14 30.3418 14.251 30.3418 14.5606C30.3418 14.8703 30.5927 15.1212 30.9024 15.1212H32.086L30.1889 17.0184C29.9699 17.2373 29.9699 17.5923 30.1889 17.8111C30.2983 17.9206 30.4418 17.9754 30.5853 17.9754C30.7287 17.9754 30.8723 17.9206 30.9816 17.8111L32.8788 15.914V17.0977C32.8788 17.4073 33.1297 17.6583 33.4394 17.6583C33.749 17.6583 34 17.4073 34 17.0977V14.5606C34 14.251 33.749 14 33.4394 14Z"
                                            fill="black" />
                                        <path
                                            d="M18.0184 29.1888L16.1212 31.0859V29.9023C16.1212 29.5926 15.8703 29.3416 15.5606 29.3416C15.251 29.3416 15 29.5926 15 29.9023V32.4393C15 32.7489 15.251 32.9999 15.5606 32.9999H18.0977C18.4073 32.9999 18.6583 32.7489 18.6583 32.4393C18.6583 32.1296 18.4073 31.8787 18.0977 31.8787H16.914L18.8111 29.9815C19.0301 29.7626 19.0301 29.4077 18.8111 29.1888C18.5924 28.9698 18.2372 28.9698 18.0184 29.1888Z"
                                            fill="black" />
                                        <path
                                            d="M16.914 15.1212H18.0977C18.4073 15.1212 18.6583 14.8703 18.6583 14.5606C18.6583 14.251 18.4073 14 18.0977 14H15.5606C15.251 14 15 14.251 15 14.5606V17.0977C15 17.4073 15.251 17.6583 15.5606 17.6583C15.8703 17.6583 16.1212 17.4073 16.1212 17.0977V15.914L18.0184 17.8111C18.1278 17.9206 18.2713 17.9754 18.4148 17.9754C18.5582 17.9754 18.7018 17.9206 18.8111 17.8111C19.0301 17.5923 19.0301 17.2373 18.8111 17.0184L16.914 15.1212Z"
                                            fill="black" />
                                        <path
                                            d="M33.4394 29.3416C33.1297 29.3416 32.8788 29.5926 32.8788 29.9023V31.0859L30.9816 29.1888C30.7629 28.9698 30.4077 28.9698 30.1889 29.1888C29.9699 29.4077 29.9699 29.7626 30.1889 29.9815L32.086 31.8787H30.9024C30.5927 31.8787 30.3418 32.1296 30.3418 32.4393C30.3418 32.7489 30.5927 32.9999 30.9024 32.9999H33.4394C33.749 32.9999 34 32.7489 34 32.4393V29.9023C34 29.5926 33.749 29.3416 33.4394 29.3416Z"
                                            fill="black" />
                                        <path
                                            d="M30.3414 27.2851H18.881C18.2142 27.2851 17.6716 26.7614 17.6716 26.1176V21.1049C17.6716 20.4611 18.2142 19.9374 18.881 19.9374H30.3414C31.0081 19.9374 31.5507 20.4611 31.5507 21.1049V26.1176C31.5507 26.7614 31.0081 27.2851 30.3414 27.2851ZM18.881 21.0179C18.8314 21.0179 18.7909 21.057 18.7909 21.1049V26.1176C18.7909 26.1655 18.8314 26.2046 18.881 26.2046H30.3414C30.391 26.2046 30.4314 26.1655 30.4314 26.1176V21.1049C30.4314 21.057 30.391 21.0179 30.3414 21.0179H18.881Z"
                                            fill="#188753" />
                                    </svg>
                                </a>
                            </li>
                            <li class="nav-item dropdown user-menu">
                                <a class="dropdown-toggle admin-btn me-2 me-sm-3 me-xl-0" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="admin-img me-1 me-sm-2"
                                        src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('backend/assets/dist/img/avatar.jpg') }}"
                                        alt="{{ localize('profile_picture') }}" />
                                    <span
                                        class="fw-bold fs-15 lh-sm text-start d-none d-md-block">{{ auth()->user() ? ucwords(auth()->user()->full_name) : '' }}<br />
                                        <span
                                            class="fs-12">{{ auth()->user()->user_type_id == 1 ? 'Admin' : 'Staff' }}</span></span>
                                </a>
                                <div class="dropdown-menu new-dropdown shadow">
                                    <div class="dropdown-header d-sm-none">
                                        <a href="" class="header-arrow"><i
                                                class="icon ion-md-arrow-back"></i></a>
                                    </div>
                                    <div class="user-header">
                                        <div class="img-user">
                                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('backend/assets/dist/img/avatar.jpg') }}"
                                                alt="{{ localize('profile_picture') }}" />
                                        </div>
                                        <!-- img-user -->
                                        <h6>{{ auth()->user() ? ucwords(auth()->user()->full_name) : '' }}</h6>
                                        <span>{{ auth()->user() ? auth()->user()->email : '' }}</span>
                                    </div>
                                    <!-- user-header -->
                                    <div class="mb-3 text-center">
                                        <a href="{{ route('empProfile') }}"
                                            class="color_1 fs-16">{{ localize('manage_your_account') }}</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="bg-smoke text-black rounded-3 px-3 py-2">{{ localize('sign_out') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                        <button class="btn bg-smoke text-danger rounded-3 px-3 py-2">Close</button>
                                    </div>
                                </div>
                                <!--/.dropdown-menu -->
                            </li>
                        </ul>
                        <!--/.navbar nav-->
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="typcn typcn-th-menu-outline"></i>
                    </button>
                </nav>
                <!--/.navbar-->
                <div class="body-content">
                    {{-- <div class="tile"> --}}

                    @yield('content')

                    {{-- </div> --}}
                </div>
                <!--/.body content-->
            </div>
            <!--/.main content-->
            @include('backend.layouts.footer')
            <!--/.footer content-->
            <div class="overlay"></div>
        </div>
        <!--/.wrapper-->
    </div>
    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateProfile" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {{ localize('update_profile_information') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="userProfileUpdate" action="{{ route('profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>{{ localize('full_name') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" id="full_name" class="form-control"
                                            value="{{ Auth::user()->full_name }}">
                                        <span class="text-danger error_full_name"></span>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>{{ localize('contact_no') }}<span class="text-danger">*</span></label>
                                        <input type="number" name="contact_no" id="contact_no" class="form-control"
                                            value="{{ Auth::user()->contact_no }}">
                                        <span class="text-danger error_contact_no"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 text-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="profilePictureUpload" class="label-upload">
                                                <div class="avatar-upload">
                                                    <input type="file" id="profilePictureUpload"
                                                        name="profile_image" class="txt-file">
                                                    <div class="avatar-preview">
                                                        <div id="profilePicturePreview"
                                                            style="background-image: url({{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('backend/assets/dist/img/avatar.jpg') }})">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                            <label>{{ localize('profile_picture') }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="signatureUpload" class="label-upload">
                                                <div class="avatar-upload">
                                                    <input type="file" id="signatureUpload" name="signature"
                                                        class="txt-file">
                                                    <div class="signature-preview">
                                                        <div id="signaturePreview"
                                                            style="background-image: url({{ Auth::user()->signature ? asset('storage/' . Auth::user()->signature) : asset('backend/assets/dist/img/nopreview.jpeg') }})">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                            <label>{{ localize('signature') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">{{ localize('close') }}</button>
                        <button class="btn btn-success">{{ localize('update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {{ localize('change_password') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm" action="{{ route('profile.changePassword') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group mb-2">
                                        <label>{{ localize('current_password') }}</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control" required autocomplete="current-password">
                                        <div class="text-danger" id="current_password_error"></div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>{{ localize('new_password') }}</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            required autocomplete="new-password">
                                        <div class="text-danger" id="new_password_error"></div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>{{ localize('confirm_password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                        <button type="reset" class="btn btn-warning">{{ localize('reset') }}</button>
                        <button class="btn btn-success">{{ localize('update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('backend.layouts.assets.js')
    @include('sweetalert::alert')

    <script src="{{ asset('backend/assets/menuSearch.js') }}"></script>
    <script src="{{ asset('backend/assets/dist/js/localization.js') }}"></script>
    <script src="{{ asset('backend/assets/common/ajax-data-submit.js') }}"></script>
    <script src="{{ asset('backend/assets/common/custom.min.js') }}"></script>

    @stack('js')
    <script>
        @if (session()->has('toastr'))
            toastr.error("{{ session('toastr') }}");
        @endif
    </script>
</body>

</html>
