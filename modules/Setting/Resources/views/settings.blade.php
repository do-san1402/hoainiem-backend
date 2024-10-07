@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            @include('backend.layouts.common.validation')
            @include('backend.layouts.common.message')
            <div class="flex-fill w-100">
                <div class="card-body">
                    <div class="row">
                        @include('setting::__setting_left')
                        <div class="col-md-12 col-lg-10 setting_content">
                            @yield('setting_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
