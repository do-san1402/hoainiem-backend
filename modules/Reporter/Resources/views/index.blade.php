@extends('backend.layouts.app')
@section('title', localize('reporters'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('reporters') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        @can('create_reporter')
                            <a href="#" class="btn btn-success btn-sm" onclick="addReporterDetails()"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('new_reporter') }}</a>
                        @endcan

                        
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

    <!-- Modal -->
    <div class="modal fade" id="projectDetailsModal" aria-labelledby="addReporterDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReporterDetailsModalLabel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal">×</button>
                </div>
                <form id="projectDetailsForm" method="POST" enctype="multipart/form-data">
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

        <input type="hidden" id="reporter_create" value="{{ route('reporter.create') }}">
        <input type="hidden" id="reporter_store" value="{{ route('reporter.store') }}">
        <input type="hidden" id="lang_add_reporter" value="{{ ucwords(localize('add_reporter')) }}">

        <input type="hidden" id="reporter_edit" value="{{ route('reporter.edit', ':reporter') }}">
        <input type="hidden" id="reporter_update" value="{{ route('reporter.update', ':reporter') }}">
        <input type="hidden" id="lang_update_reporter" value="{{ ucwords(localize('update_reporter')) }}">

        <input type="hidden" id="get_data_table_id" value="reporter-table">
        
    </div>

@endsection
@push('js')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Reporter/js/reporter.js') }}"></script>

@endpush
