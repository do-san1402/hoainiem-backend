@extends('setting::settings')
@section('title', localize('user_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('user_list') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addUser"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_user') }}</a>
                            @include('usermanagement::user-management.user-create')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ localize('edit_user') }}
                    </h5>
                </div>
                <div id="editUserData">

                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('UserManagement/js/userList.js') }}"></script>
@endpush
