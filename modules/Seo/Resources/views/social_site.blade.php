@extends('backend.layouts.app')
@section('title', localize('social_page'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('social_page') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="projectDetailsNonModalForm" action="{{ route('seo.social_site_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="fb"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('facebook_page_url')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="fb" name="fb"
                                        placeholder="{{ ucwords(localize('facebook_page_url')) }}" value="{{ old('fb') ?? $existing_social_page->fb }}">
                                </div>

                                @if ($errors->has('fb'))
                                    <div class="error text-danger m-2">{{ $errors->first('fb') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="tw"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('twitter_page_url')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="tw" name="tw"
                                        placeholder="{{ ucwords(localize('twitter_page_url')) }}" value="{{ old('tw') ?? $existing_social_page->tw }}">
                                </div>

                                @if ($errors->has('tw'))
                                    <div class="error text-danger m-2">{{ $errors->first('tw') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-3 text-start">
                                    <label for="status"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('status') }}</label>
                                </div>
                                <div class="col-md-5 text-start">
                                    <div class="me-3">
                                        <input type="radio" name="status" value="1"
                                            {{ $existing_social_page->status == '1' ? 'checked' : '' }}> <span
                                            class="ps-2">{{ localize('active') }}</span>
                                    </div>
                                    <div>
                                        <input type="radio" name="status" value="0"
                                            {{ $existing_social_page->status == '0' ? 'checked' : '' }}><span
                                            class="ps-2">{{ localize('inactive') }}</span>
                                    </div>
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
