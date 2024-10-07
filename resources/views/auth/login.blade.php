@extends('login.app')
@section('title', localize('login'))
@section('content')

    <div class="d-flex align-items-center justify-content-center text-center login-bg h-100vh"
        style="background-image: url({{ app_setting()->login_image }});">
        <div class="form-wrapper position-relative m-auto">
            <div class="form-container my-4">
                <div class="panel login-form-w">
                    <div class="panel-header text-center mb-3">
                        <div class="mb-3">
                            <img src="{{ app_setting()->logo }}" class="img" width="180" height="90"
                                alt="">
                        </div>
                        <h3 class="fs-24 fw-bold mb-1">{{ app_setting()->title }} Login</h3>
                        <p class="fw--semi-bold text-center fs-14 mb-0">Welcome Back, {{ app_setting()->title }}</p>
                    </div>

                    {{-- Displaying the custom error message --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form class="register-form text-start" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semi-bold">{{ localize('email_address') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="Enter Email Address" />

                            @error('email')
                                <span class="text-danger text-start" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label fw-semi-bold">{{ localize('password') }}</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="pass"
                                placeholder="Enter your Password" />
                            @error('password')
                                <span class="text-danger text-start" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if(config('demo.demo_mode'))
                            <div class="panel-footer mt-5 bg-light login-info">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 12px;">
                                        <tr>
                                            <td>admin@admin.com</td>
                                            <td>12345678</td>
                                            <td>Admin</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="form-check mb-3 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-black fw-medium">{{ localize('forgot_password') }}</a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success py-2 w-100">{{ localize('sign_in') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
