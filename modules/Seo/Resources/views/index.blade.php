@extends('backend.layouts.app')
@section('title', localize('meta_settings'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('meta_settings') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="projectDetailsNonModalForm" action="{{ route('seo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="title"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('title') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="{{ localize('title') }}" value="{{ old('title') ?? $existing_meta->title }}">
                                </div>

                                @if ($errors->has('title'))
                                    <div class="error text-danger m-2">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="meta_keyword"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('meta_keyword') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">

                                    <textarea  class="form-control" id="meta_keyword" name="meta_keyword"
                                        placeholder="{{ localize('meta_keyword') }}" rows ="4">{{ $existing_meta->meta_tag }}</textarea>
                                </div>

                                @if ($errors->has('meta_keyword'))
                                    <div class="error text-danger m-2">{{ $errors->first('meta_keyword') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="meta_description"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('meta_description') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">

                                    <textarea  class="form-control" id="meta_description" name="meta_description"
                                        placeholder="{{ localize('meta_description') }}" rows ="4">{{ $existing_meta->meta_description }}</textarea>
                                </div>

                                @if ($errors->has('meta_description'))
                                    <div class="error text-danger m-2">{{ $errors->first('meta_description') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="google_analytics_id"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('google_analytics_id') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id"
                                        placeholder="{{ localize('google_analytics_id') }}" value="{{ old('google_analytics') ?? $existing_meta->google_analytics }}" required>
                                </div>

                                @if ($errors->has('google_analytics_id'))
                                    <div class="error text-danger m-2">{{ $errors->first('google_analytics_id') }}</div>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="default_image"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('default_image') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">

                                    <input type="file" class="form-control" id="default_image" name="default_image"
                                    class="form-control" aria-describedby="categoryNote" accept="image/*" autocomplete="off">

                                    <small id="categoryNote" class="form-text text-black">N.B: {{ localize('max size 1MB') }}</small>

                                    <small id="fileHelp" class="text-muted mt-2">
                                    <img src="{{ $existing_meta->default_image != NULL && file_exists(storage_path('app/public/' . $existing_meta->default_image)) ? asset('storage/' . $existing_meta->default_image) : asset('backend/assets/dist/img/signature_signature.jpg') }}" id="output" class="img-thumbnail mt-2" width="300" style="height: 120px !important;">
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card-footer form-footer text-start">
                            <button type="submit" class="btn btn-success me-2"></i>{{ localize('update') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection
@push('js')

    <script src="{{ module_asset('Seo/js/seo.js') }}"></script>

@endpush

