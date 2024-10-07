@extends('backend.layouts.app')
@section('title', localize('social_link'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('social_link') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="projectDetailsNonModalForm" action="{{ route('seo.social_link_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="fb"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('facebook')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="fb" name="fb"
                                        placeholder="{{ ucwords(localize('facebook')) }}" value="{{ old('fb') ?? $existing_social_link->fb }}">
                                </div>

                                @if ($errors->has('fb'))
                                    <div class="error text-danger m-2">{{ $errors->first('fb') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="tw"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('twitter')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="tw" name="tw"
                                        placeholder="{{ ucwords(localize('twitter')) }}" value="{{ old('tw') ?? $existing_social_link->tw }}">
                                </div>

                                @if ($errors->has('tw'))
                                    <div class="error text-danger m-2">{{ $errors->first('tw') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="linkd"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('linkedin')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="linkd" name="linkd"
                                        placeholder="{{ ucwords(localize('linkedin')) }}" value="{{ old('linkd') ?? $existing_social_link->linkd }}">
                                </div>

                                @if ($errors->has('linkd'))
                                    <div class="error text-danger m-2">{{ $errors->first('linkd') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="pin"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('pinterest')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="pin" name="pin"
                                        placeholder="{{ ucwords(localize('pinterest')) }}" value="{{ old('pin') ?? $existing_social_link->pin }}">
                                </div>

                                @if ($errors->has('pin'))
                                    <div class="error text-danger m-2">{{ $errors->first('pin') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="vimo"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('vimeo')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="vimo" name="vimo"
                                        placeholder="{{ ucwords(localize('vimeo')) }}" value="{{ old('vimo') ?? $existing_social_link->vimo }}">
                                </div>

                                @if ($errors->has('vimo'))
                                    <div class="error text-danger m-2">{{ $errors->first('vimo') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="youtube"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('youtube')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="youtube" name="youtube"
                                        placeholder="{{ ucwords(localize('youtube')) }}" value="{{ old('youtube') ?? $existing_social_link->youtube }}">
                                </div>

                                @if ($errors->has('youtube'))
                                    <div class="error text-danger m-2">{{ $errors->first('youtube') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="flickr"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('flickr')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="flickr" name="flickr"
                                        placeholder="{{ ucwords(localize('flickr')) }}" value="{{ old('flickr') ?? $existing_social_link->flickr }}">
                                </div>

                                @if ($errors->has('flickr'))
                                    <div class="error text-danger m-2">{{ $errors->first('flickr') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="vk"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('vk')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="vk" name="vk"
                                        placeholder="{{ ucwords(localize('vk')) }}" value="{{ old('vk') ?? $existing_social_link->vk }}">
                                </div>

                                @if ($errors->has('vk'))
                                    <div class="error text-danger m-2">{{ $errors->first('vk') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="whats_app"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('whats_app')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="whats_app" name="whats_app"
                                        placeholder="{{ ucwords(localize('whats_app')) }}" value="{{ old('whats_app') ?? $existing_social_link->whats_app ?? null }}">
                                </div>

                                @if ($errors->has('vk'))
                                    <div class="error text-danger m-2">{{ $errors->first('vk') }}</div>
                                @endif
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
