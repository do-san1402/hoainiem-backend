@extends('setting::settings')
@section('title', localize('menu_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('menu_list') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addmenu"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_menu') }}</a>
                            @include('usermanagement::role-management.menu-create')
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
    <div class="modal fade" id="editMenu" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Edit Menu
                    </h5>
                </div>
                <div id="editMenuData">

                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('UserManagement/js/menuStoreandDelete.js') }}"></script>
@endpush
