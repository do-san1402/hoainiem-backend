@extends('backend.layouts.app')
@section('title', ucwords(localize('add_new_page')))
@push('css')
    <link href="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.css') }}" rel="stylesheet">
@endpush

@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ ucwords(localize('add_new_page')) }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="pageDetailsNonModalForm" action="{{ route('page.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-sm-12 col-md-12 col-xl-12">

                                            <label for="video_url"
                                                class="col-form-label fw-semibold">{{ localize('photo') }}</label>

                                            <input type="file" class="form-control" id="image" name="image"
                                            class="form-control" aria-describedby="imageNote" accept="image/*" autocomplete="off">

                                            <small id="imageNote" class="form-text text-black">N.B: {{ localize('jpg,png,jpeg and max size is 1MB') }}</small>

                                        </div>
                                
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-sm-12 col-md-12 col-xl-12">

                                            <label for="videos"
                                                class="col-form-label fw-semibold">{{ localize('video_url') }}</label>

                                            <input type="text" class="form-control" id="videos" name="videos"
                                            placeholder="{{ localize('video_url') }}" value="{{ old('video_url') }}">

                                        </div>

                                        @if ($errors->has('videos'))
                                            <div class="error text-danger m-2">{{ $errors->first('videos') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12 col-xl-12">

                                    <label for="title" class="col-form-label fw-semibold">{{ localize('title') }}<span
                                        class="text-danger">*</span></label>

                                    <input type="text" class="form-control" id="title" name="title"
                                            placeholder="{{ localize('title') }}" value="{{ old('title') }}" required>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row form-group">

                                <div class="page_slug text-end"><a href="javascript:void(0)" class="text-primary fw-bold">{{ localize('page_slug') }}</a></div>

                                <div class="col-sm-12 col-md-12 col-xl-12" id="slug">

                                    <input type="text" class="form-control" name="slug"
                                            placeholder="{{ localize('page_slug') }}" value="{{ old('slug') }}">
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12 col-xl-12">

                                    <label for="details_news" class="col-form-label fw-semibold">{{ localize('details') }}</label>

                                    <textarea  class="form-control" id="details_news" name="details_news"
                                    placeholder="{{ localize('details') }}" rows ="10" cols="80"></textarea>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12 col-xl-12">

                                    <label for="meta_keyword" class="col-form-label fw-semibold">{{ localize('meta_keyword') }}</label>

                                        <input type="text" id="tags" name="meta_keyword" class="form-control" data-role="tagsinput">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12 col-xl-12">

                                    <label for="meta_description" class="col-form-label fw-semibold">{{ localize('meta_description') }}</label>

                                        <textarea  class="form-control" name="meta_description"
                                            placeholder="{{ localize('meta_description') }}" rows ="5"></textarea>
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card-footer form-footer text-start">
                            <button type="submit" class="btn btn-success me-2"></i>{{ localize('save') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <input type="hidden" id="image_up" value="{{route('page.ckeditor_upload', ['_token' => csrf_token() ])}}">

@endsection

@push('js')

    <script src="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.js') }}"></script>
    <script src="{{ module_asset('Page/js/ck.js') }}"></script>

@endpush
