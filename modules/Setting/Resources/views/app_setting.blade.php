@extends('setting::settings')
@section('title', localize('apps_setting'))
@push('css')
    <style>
        .disablecontent {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
@endpush
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('edit_apps_setting') }}</h6>
                    </div>
                </div>
            </div>

            <form action="{{ route('app.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6" id="printArea">
                            <table class="table table-responsive">
                                <tbody>
                                    <tr>
                                        <span class="qr-text">Attendance QR code</span>
                                        <td>{!! DNS2D::getBarcodeHTML(url('/') . '/api/', 'QRCODE') !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <a href="https://play.google.com/store/apps/details?id=com.bdtaskhrm" target="blank">
                                <h2>Download Mobile Apps From
                                    Play Store</h2>
                            </a>
                            <h1 class="text-center mt-3"><a
                                    href="https://play.google.com/store/apps/details?id=com.bdtaskhrm" target="blank"
                                    class="text-center"><i class="fa-brands fa-android fa-2xl"
                                        style="color: #347cf9;"></i></a></h1>
                        </div>
                    </div>
                    <div class="row disablecontent">
                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="latitude" class="col-md-3 col-form-label">{{ localize('latitude') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="latitude" class="form-control" id="latitude"
                                        value="{{ @$app->latitude }}">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="longitude" class="col-md-3 col-form-label">{{ localize('longitude') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="longitude" class="form-control" id="longitude"
                                        value="{{ @$app->longitude }}">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="acceptable_range"
                                    class="col-md-3 col-form-label">{{ localize('acceptable_range') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="acceptablerange" class="form-control" id="acceptable_range"
                                        value="{{ @$app->acceptablerange }}">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="google_api_auth_key"
                                    class="col-md-3 col-form-label">{{ localize('google_api_auth_key') }}</label>
                                <div class="col-md-9">
                                    <input type="text" name="googleapi_authkey" class="form-control"
                                        id="google_api_auth_key" value="{{ @$app->googleapi_authkey }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end disablecontent">
                                <button type="submit" class="btn btn-success">{{ localize('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer form-footer">
                    <div class="row text-center mb-3">
                        <div class="col-12">
                            <h2>To enable Mobile apps addons for your business please contact at:</h2>
                            <span class="text-danger">business@bdtask.com</span>, Skype: <span
                                class="text-danger">bdtask</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
@endpush
