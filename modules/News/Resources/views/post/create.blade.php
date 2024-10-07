@extends('backend.layouts.app')
@section('title', localize('create_photo_post'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('create_photo_post') }}</h6>
                </div>
                <div class="float-right">
                    @can('read_post')
                        <a class="btn btn-success btn-sm" href="{{ route('news.post.index') }}" >
                            {{ localize('post_list') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('news.post.store') }}" class="needs-validation" data="showCallBackData"
                id="news-post-form" novalidate="" method="POST" enctype="multipart/form-data">
                @csrf

                @include('news::post.form')

                <div>
                    <div class="col-xl-2 col-md-2 mt-3 align-self-end">
                        <button type="submit" class="btn btn-success">{{ localize('Create') }}</button>
                        <button type="reset" class="btn btn-danger">{{ localize('reset') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="add_gallery_image_div" class="d-none">
            <div class="row gallery_image_div" id="SetDivId">
                <div class="col-lg-3 col-md-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-600">{{ localize('image') }}</label>
                        <div class="btn-select-image">
                            <div id="photo-library-previewSetDivId">
                            </div>
                            <input type="hidden" name="lib_file_selected[]" id="photo_library_nameSetDivId" value="">
                            <a href="{{ route('photo-library.view', ['div_id' => 'SetDivId']) }}"
                                class="photo-library-page text-success">
                                <i class="fa fa-cloud-upload-alt"></i> [ jpg,png,jpeg,gif]
                            </a>
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <label for="image_alt"
                                class="col-form-label fw-semibold">{{ localize_uc('image_alt') }}</label>
                            <input type="text" id="image_altSetDivId" name="image_alt[]" class="form-control"
                                placeholder="{{ localize_uc('enter_image_alt') }}" value="">
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <label for="image_title"
                                class="col-form-label fw-semibold">{{ localize_uc('image_title') }}</label>
                            <input type="text" id="image_titleSetDivId" name="image_title[]" class="form-control"
                                placeholder="{{ localize_uc('enter_image_title') }}" value="">
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-6">
                    <button type="button" class="btn btn-sm btn-danger mt-4 delete-photo-gallery-button">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ module_asset('News/js/news/news-post.js') }}"></script>
    @endpush
