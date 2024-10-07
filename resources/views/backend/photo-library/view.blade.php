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
    <title>{{ localize_uc('image_library') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" class="favicon_show" href="{{ app_setting()->favicon }}">
    @include('backend.layouts.assets.css')
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
        <!-- Page Content  -->
        <div class="content-wrapper">
            <div class="main-content">

                <div class="body-content">
                    @include('backend.layouts.common.message')

                    <div class="tab-content" id="pills-tabContent">
                        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="fs-17 font-weight-600 mb-0">
                                                        {{ localize('insert_image') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('photo-library.store') }}" method="post"
                                                class="needs-validation" data="showCallBackViewData" id="photo-library-form"
                                                novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                @include('backend.photo-library.form')
                                                <div class="row">
                                                    <div class="col-md-12 mt-3 text-start">
                                                        <button type="reset" class="btn btn-danger" title="{{ localize('reset') }}">
                                                            <i class="fa fa-undo-alt"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            {{ localize('upload_image') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="fs-17 font-weight-600 mb-0">
                                                        {{ localize_uc('images_list') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <form action="{{ route('photo-library.view') }}" method="get">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="name"
                                                                id="name"
                                                                value="{{ old('name', request()->name) }}"
                                                                placeholder="{{ localize_uc('search') }}">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-success"
                                                                    type="submit">{{ localize_uc('search') }}</button>
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('photo-library.view') }}">{{ localize_uc('reset') }}</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center p-3" id="show-images">
                                                @foreach ($imageLibraries as $imageLibrary)
                                                    @php
                                                        $image_path = !$imageLibrary->disk || $imageLibrary->disk == 'local' ? storage_asset_image($imageLibrary->thumb_image) : $imageLibrary->image_base_url;
                                                    @endphp
                                                    <div class="m-2 photo-library-element"
                                                        data-id="{{ $imageLibrary->uuid }}"
                                                        data-actual_image_name="{{ $imageLibrary->actual_image_name }}"
                                                        data-thumb_image="{{ $image_path }}"
                                                        data-caption="{{ $imageLibrary->title }}">
                                                        <p class="photo-library-element-title">{{ $imageLibrary->title }}</p>
                                                        <img class="img-responsive img-thumbnail photo-library-img"
                                                            src="{{ $image_path }}"
                                                            alt="{{ $imageLibrary->title }}" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" id="photo_library_div_id" value="{{ $div_id ?? null }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

    @include('backend.layouts.assets.js')
    @include('sweetalert::alert')

    <script src="{{ asset('backend/assets/menuSearch.js') }}"></script>
    <script src="{{ asset('backend/assets/dist/js/localization.js') }}"></script>
    <script src="{{ asset('backend/assets/common/ajax-data-submit.js') }}"></script>
    <script src="{{ asset('backend/assets/common/custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/photo-library.js') }}"></script>

    <script>
        @if (session()->has('toastr'))
            toastr.error("{{ session('toastr') }}");
        @endif
    </script>
</body>

</html>
