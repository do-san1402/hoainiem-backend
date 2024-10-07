@extends('login.app')
@section('title', localize('reset_password'))

@section('content')

    <div class="d-flex align-items-center justify-content-center text-center h-100vh">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">

                <div class="register-logo text-center mb-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ app_setting()->logo }}" alt="">
                    </a>
                </div>

                <div class="panel">
                    <div class="panel-header text-center mb-3">
                        <h3 class="fs-24">{{ localize('reset_password') }}</h3>
                        <p class="text-muted text-center mb-0">{{ localize('reset_password_reset_instruction') }}</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="register-form">
                        @csrf

                        <div class="form-group">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="{{ localize('email_address') }}" required autocomplete="email"
                                autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <button type="submit"
                            class="btn btn-success btn-block mt-4 w-100">{{ localize('send_password_reset_link') }}</button>
                        <p class="text-muted text-center mt-3 mb-0">{{ localize('remember_password') }} <a class="external"
                                href="{{ route('login') }}">{{ localize('sign_in') }}</a>.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.End of form wrapper -->

@endsection
