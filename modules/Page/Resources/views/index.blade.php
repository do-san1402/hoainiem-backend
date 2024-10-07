@extends('backend.layouts.app')
@section('title', localize('page_list'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('page_list') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        @can('create_page')
                            <a href="{{ route('page.create') }}" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_new_page') }}</a>
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

        <input type="hidden" id="get_data_table_id" value="page-table">

    </div>

@endsection
@push('js')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Page/js/page.js') }}"></script>

@endpush
