@extends('backend.layouts.app')
@section('title', localize('news_list'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')


    <div class="card mb-4">

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('news_list') }}</h6>
                </div>
                <div class="float-right">
                    <a class="btn btn-success btn-sm" data-bs-toggle="collapse" href="#collapseFilter" role="button"
                        aria-expanded="false" aria-controls="collapseFilter">
                        <i class="fa fa-filter"></i>&nbsp;
                        {{ localize('filter') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('news::filter')
            <div class="table_customize">
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>

@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('News/js/news-index.js') }}"></script>
@endpush
