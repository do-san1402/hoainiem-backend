@extends('setting::settings')
@section('title', localize('space_credential'))
@push('css')
@endpush

@section('setting_content')
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('space_credential') }}</h6>
                            </div>
                            <div class="float-right">
                                @can('create_space_credential')
                                    <button class="btn btn-success btn-sm" id="add-new-space-credential"
                                        title="{{ localize_uc('add_new_space_credential') }}">
                                        <i class="fa fa-edit"></i> {{ localize_uc('add_new') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table_customize">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-common-modal modalId="space_credential_model" :modalTitle="localize_uc('add_space_credential')" modalDialog="modal-md" :modelUpdateTitle="localize_uc('update_space_credential')" >
        <form action="{{ route('space-credential.store') }}" method="post" class="needs-validation" data="showCallBackData" id="spaceCredentialForm"
            data-insert="{{ route('space-credential.store') }}"  enctype="multipart/form-data"
            novalidate="">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="key" class="col-form-label fw-semibold">{{ localize_uc('key') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="key" id="key"
                            class="form-control @error('key') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_key') }}" value="{{ old('key') }}" required="" />
                        <div class="invalid-feedback error text-danger m-2">
                            @error('key')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="secret" class="col-form-label fw-semibold">{{ localize_uc('secret') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="secret" id="secret"
                            class="form-control @error('secret') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_secret') }}" value="{{ old('secret') }}" required="" />
                        <div class="invalid-feedback error text-danger m-2">
                            @error('secret')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="region" class="col-form-label fw-semibold">{{ localize_uc('region') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="region" id="region"
                            class="form-control @error('region') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_region') }}" value="{{ old('region') }}" required="" />
                        <div class="invalid-feedback error text-danger m-2">
                            @error('region')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="bucket" class="col-form-label fw-semibold">{{ localize_uc('bucket') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="bucket" id="bucket"
                            class="form-control @error('bucket') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_bucket') }}" value="{{ old('bucket') }}" required="" />
                        <div class="invalid-feedback error text-danger m-2">
                            @error('bucket')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="url" class="col-form-label fw-semibold">{{ localize_uc('url') }}</label>
                        <input type="text" name="url" id="url"
                            class="form-control @error('url') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_url') }}" value="{{ old('url') }}" />
                        <div class="invalid-feedback error text-danger m-2">
                            @error('url')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row gap-3 py-3">
                <button type="reset" class="btn btn-danger w-25" title="{{ localize('Reset') }}">
                    <i class="fa fa-undo-alt"></i>
                </button>
                <button type="submit" class="btn btn-success w-75" id="submit_button" data-create="{{ localize('create') }}" data-update="{{ localize('update') }}">{{ localize('Create') }}</button>
            </div>
        </form>
    </x-common-modal>
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Setting/js/space-credential.js') }}"></script>
@endpush
