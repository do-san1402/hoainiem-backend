@extends('setting::settings')
@section('title', localize('assign_permission_to_role_list'))
@section('setting_content')
    <div class="body-content pt-0">

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('role_list') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">
                            <a href="{{ route('role.add') }}" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_role') }}</a>
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
    <script src="{{ module_asset('UserManagement/js/roleList.js') }}"></script>
@endpush
