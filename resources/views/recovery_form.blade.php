@extends('login.app')
@section('title', localize('password_recovery'))
@section('content')

    <div class="d-flex align-items-center justify-content-center text-center login-bg h-100vh"
        style="background-image: url({{ app_setting()->login_image }});">

         @include('backend.layouts.common.message')

        <div class="form-wrapper position-relative m-auto">
            <div class="form-container my-4">
                <div class="panel login-form-w">
                    <div class="panel-header text-center mb-3">
                        <div class="mb-3">
                            <img src="{{ app_setting()->favicon }}" class="rounded-circle" width="90" height="90"
                                alt="">
                        </div>
                        <h3 class="fs-24 fw-bold mb-1">{{ app_setting()->title }}</h3>
                        <p class="fw--semi-bold text-center fs-14 mb-0"> {{localize('password_recovery')}}</p>
                    </div>


                    <form class="register-form text-start" action="{{ route('recovery_submit', $token) }}" method="POST">
                        <div class="mb-3">
                            <label for="pass" class="form-label fw-semi-bold">{{ localize('password') }}</label>
                            <input type="password" name="password"
                                class="form-control" id="pass"
                                placeholder="Enter your Password" required />
                            <span class="text-danger">Note: password must be at least 8 characters</span>
                            
                            <input type="hidden" name="token" value="{{$token}}">
                            
                        </div>
                        <button type="submit" class="btn btn-success py-2 w-100">{{ localize('update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
