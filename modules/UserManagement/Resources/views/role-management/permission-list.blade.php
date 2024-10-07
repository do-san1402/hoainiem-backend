{{-- @extends('backend.layouts.app') --}}
@extends('setting::settings')
@section('title', localize('permission_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('permission_list') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">
                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addPermission"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_permission') }}</a>
                            @include('usermanagement::role-management.permission-create')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('UserManagement/js/permissionStoreandDelete.js') }}"></script>
@endpush
