@extends('backend.layouts.app')
@section('title', localize('categories'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('categories') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        @can('create_category')
                            <a href="#" class="btn btn-success btn-sm" onclick="addCategoryDetails()"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('new_category') }}</a>
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
    <div class="modal fade" id="projectDetailsModal" aria-labelledby="addCategoryDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryDetailsModalLabel"></h5>
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

        <input type="hidden" id="category_create" value="{{ route('category.create') }}">
        <input type="hidden" id="category_store" value="{{ route('category.store') }}">
        <input type="hidden" id="lang_add_category" value="{{ ucwords(localize('add_category')) }}">

        <input type="hidden" id="category_edit" value="{{ route('category.edit', ':category') }}">
        <input type="hidden" id="category_update" value="{{ route('category.update', ':category') }}">
        <input type="hidden" id="lang_update_category" value="{{ ucwords(localize('update_category')) }}">

        <input type="hidden" id="get_data_table_id" value="category-table">

    </div>

@endsection
@push('js')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Category/js/category.js') }}"></script>

@endpush
