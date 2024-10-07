@extends('setting::settings')
@section('title', localize('backup_reset'))
@push('css')
    <link rel="stylesheet" href="{{ module_asset('Setting/css/database-backup-modal.css') }}">
@endpush
@section('setting_content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')

    <div class="card mb-4 border">
        <div class="card-header py-3">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('database_backup') }}</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @can('create_factory_reset')
                        <button type="button" id="database_backup_button"
                            class="btn btn-success">{{ localize('backup_database') }}</button>
                        <form id="database_backup" action="{{ route('backup.create') }}" method="POST">
                            @csrf
                        </form>
                    @endcan
                </div>
                <div class="col-md-12 mt-5">
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('disk') }}</th>
                                    <th>{{ localize('size') }}</th>
                                    <th>{{ localize('last_modified') }}</th>
                                    <th>{{ localize('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $si = 1;
                                @endphp
                                @foreach ($disks as $disk)
                                    @foreach ($disk as $key => $file)
                                        <tr>
                                            <td>{{ $si }} </td>
                                            <td>{{ $file['name'] }}</td>
                                            <td>{{ $file['disk'] }}</td>
                                            <td>{{ size_convert($file['size']) }}</td>
                                            <td>{{ $file['last_modified'] }}</td>
                                            <td>

                                                <a href="{{ route('backup.download', ['disk' => $file['disk'], 'url' => $file['url']]) }}"
                                                    target="_blank" class="btn btn-success-soft btn-sm" title="Download">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-danger-soft btn-sm delete-confirm"
                                                    data-bs-toggle="tooltip" title="Delete"
                                                    data-route="{{ route('backup.delete', ['disk' => $file['disk'], 'url' => $file['url']]) }}"
                                                    data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i>
                                                </a>
                                                @include('setting::backup.modal')
                                            </td>
                                        </tr>

                                        @php
                                            $si++;
                                        @endphp
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Database Reset -->
    <div class="modal fade" id="passwordEnter" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="passwordEnterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="factory_reset" action="{{ route('backup.factory_reset') }}" method="POST">
                    @csrf

                    <div class="modal-body p-4">
                        <label for="password1" class="form-label">{{ localize('enter_your_password') }}</label>
                        <input type="password" class="form-control" id="password1"
                            placeholder="{{ localize('enter_password') }}">
                        <span class="text-danger" id="passwordError"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                        @can('create_factory_reset')
                            <button type="button" class="btn btn-success submit_button">{{ localize('confirm') }}</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Database Import Password Check -->
    <div class="modal fade" id="passwordEnterForImportDatabase" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="forImportDatabase" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="password_check" action="{{ route('backup.password_check') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <label for="password2" class="form-label">{{ localize('enter_your_password') }}</label>
                        <input type="password" class="form-control" id="password2"
                            placeholder="{{ localize('enter_password') }}">
                        <span class="text-danger" id="passwordErrorForImportDatabase"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                        @can('create_factory_reset')
                            <button type="button" class="btn btn-success submit_button"
                                onclick="passwordCheckButton()">{{ localize('confirm') }}</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="database_backup_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-lg">
                <div class="modal-body">
                    <div class='loading-wrapper'>
                        <div class="processing">{{ localize('backup_processing') }}
                            <svg>
                                <rect x="1" y="1"></rect>
                            </svg>
                        </div>
                    </div>
                    <p class="processing-p">{{ localize('backup_processing_note') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="database_import_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-lg">
                <div class="modal-body">
                    <div class='loading-wrapper'>
                        <div class="processing">{{ localize('import_processing') }}
                            <svg>
                                <rect x="1" y="1"></rect>
                            </svg>
                        </div>
                    </div>
                    <p class="processing-p">{{ localize('import_processing_note') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ module_asset('Setting/js/backup_reset.js?v_' . date('h_i')) }}"></script>
@endpush
