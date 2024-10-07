@extends('setting::settings')
@section('title', localize('access_log'))
@push('css')
@endpush
@section('setting_content')

    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')

    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('access_log') }}</h6>
                </div>
                <div class="actions text-end">
                    @can('delete_product')
                        <a href="javascript:void(0)" class="btn btn-danger delete-all"><i
                                class="fa-sharp fa-solid fas fa-trash-alt"></i>
                            {{ localize('delete_selected_items') }}</a>

                        <input type="hidden" name="delete_activity_log_url" value="{{ route('multiple_delete_activity_log') }}">
                    @endcan

                    <button type="button" class="btn btn-success" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> <i
                            class="fas fa-filter"></i> {{ localize('filter') }}</button>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div id="flush-collapseOne" class="accordion-collapse collapse bg-white mb-4"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                                <div class="row">
                                    <div class="col-md-2 mb-4">
                                        <select id="user_name" class="select-basic-single"
                                            data-url="{{ route('user.search') }}">
                                            <option selected disabled>{{ localize('user_name') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <input type="text" class="form-control date-range" id="log_date"
                                            autocomplete="off" placeholder="{{ localize('log_date') }}">
                                    </div>
                                    <div class="col-md-2 mb-4 align-self-end">
                                        <button type="button" id="filter"
                                            class="btn btn-success">{{ localize('find') }}</button>
                                        <button type="button" id="search-reset"
                                            class="btn btn-danger">{{ localize('reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_customize">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

@endsection


@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Setting/js/activity_log.js?v_' . date('h_i')) }}"></script>
@endpush
