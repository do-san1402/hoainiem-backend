@extends('setting::settings')
@section('title', localize('ZKTeco_setting'))
@section('setting_content')
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('zkt_device_credentials') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <a class="btn btn-success btn-sm" onclick="addZkt()"><i class="fa-sharp fa-solid fa-circle-plus"></i>
                            {{ localize('add_new_credentials') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table_customize">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    <input type="hidden" id="zktSetupAdd" value="{{ route('zktSetup.add') }}" />
    <input type="hidden" id="zktSetupStore" value="{{ route('zktSetup.store') }}" />
    <!-- Model Chain Modal -->
    <div class="modal fade" id="zktModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="zktForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger-soft me-2"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                        <button type="submit" class="btn btn-success me-2"></i>{{ localize('save') }}</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Hidden  data -->
        <input type="hidden" id="zkt_setup_add" value="{{ route('zktSetup.add') }}">
        <input type="hidden" id="lang_add_credentials" value="{{ localize('add_credentials') }}">
        <input type="hidden" id="zkt_setup_store" value="{{ route('zktSetup.store') }}">

        <input type="hidden" id="zkt_setup_edit" value="{{ route('zktSetup.edit', ':id') }}">
        <input type="hidden" id="zkt_setup_update" value="{{ route('zktSetup.update', ':id') }}">
        <input type="hidden" id="lang_edit_credentials" value="{{ localize('edit_credentials') }}">

    </div>
@endsection
@push('js')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Setting/js/zkt.js') }}"></script>

@endpush


