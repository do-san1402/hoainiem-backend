@extends('setting::settings')
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        @include('backend.layouts.common.validation')
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">User Type List</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#create-user-type"><i class="fa fa-plus-circle"></i>&nbsp;Add User Type</a>
                            @include('usermanagement::modal.user-type-create')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10%">{{ localize('sl') }}</th>
                                <th width="50%">Title</th>
                                <th width="30%">{{ localize('status') }}</th>
                                <th width="10%">{{ localize('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userTypes as $key => $userType)
                                <tr>
                                    <td>#{{ $key + 1 }}</td>
                                    <td>{{ $userType->user_type_title }}</td>
                                    <td>
                                        @if ($userType->is_active == 1)
                                            <span class="badge bg-success">{{ localize('status') }}</span>
                                        @elseif($userType->is_active == 0)
                                            <span class="badge bg-danger">{{ localize('inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary-soft btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#edit-user_type-{{ $userType->id }}" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm"
                                            data-bs-toggle="tooltip" title="Delete"
                                            data-route="{{ route('user-types.destroy', $userType->uuid) }}"
                                            data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @include('usermanagement::modal.user-type-edit')
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ localize('empty_data') }}</td>
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
