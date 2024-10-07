@extends('setting::settings')
@section('title', localize('password_setting'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        @include('backend.layouts.common.validation')
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('password_setting') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            @if (count($passwordSettings) < 1)
                                <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#create-password-setting"><i
                                        class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_password_setting') }}</a>
                                @include('usermanagement::modal.password-setting-create')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="8%">{{ localize('sl') }}</th>
                                <th width="8%">Min Length</th>
                                <th width="10%">Max Life Time</th>
                                <th width="15%">Password Complexcity</th>
                                <th width="11%">Password History</th>
                                <th width="13%">Lock Out Duration</th>
                                <th width="15%">Session Idle Logout Time</th>
                                <th width="12%">{{ localize('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($passwordSettings as $key => $passwordSetting)
                                <tr>
                                    <td>#{{ $key + 1 }}</td>
                                    <td>{{ $passwordSetting->min_length }}</td>
                                    <td>{{ $passwordSetting->max_lifetime }}</td>
                                    <td>{{ $passwordSetting->password_complexcity }}</td>
                                    <td>{{ $passwordSetting->password_history }}</td>
                                    <td>{{ $passwordSetting->lock_out_duration }}</td>
                                    <td>{{ $passwordSetting->session_idle_logout_time }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary-soft btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#edit-setting-password-{{ $passwordSetting->id }}"
                                            title="Edit"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                                @include('usermanagement::modal.password-setting-edit')
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">{{ localize('empty_data') }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
