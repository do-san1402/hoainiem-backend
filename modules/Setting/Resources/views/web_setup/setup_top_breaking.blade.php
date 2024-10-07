@extends('backend.layouts.app')
@section('title', localize('setup_top_breaking'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('setup_top_breaking') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="projectDetailsNonModalForm" action="{{ route('view_setup.top_breaking_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="title"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('entire_title')) }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="{{ ucwords(localize('entire_title')) }}" value="{{$top_breaking != null ? $top_breaking->title:null}}" required>
                                </div>

                                @if ($errors->has('title'))
                                    <div class="error text-danger m-2">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="background_color"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('background_color')) }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="background_color" name="background_color"
                                        placeholder="{{ ucwords(localize('background_color')) }}" value="{{$top_breaking != null ? $top_breaking->background_color:null}}" required>
                                </div>

                                @if ($errors->has('background_color'))
                                    <div class="error text-danger m-2">{{ $errors->first('background_color') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="category_slug"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('category')) }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="category_slug" id="category_slug" class="form-control select-basic-single" required>
                                        <option value="">--{{ localize('select') }}--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}" {{ $top_breaking != null && $top_breaking->category_slug == $category->slug ? 'selected' : '' }}>{{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($errors->has('category_slug'))
                                    <div class="error text-danger m-2">{{ $errors->first('category_slug') }}</div>
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
                                            {{ $top_breaking != null && $top_breaking->status == '1' ? 'checked' : '' }}> <span
                                            class="ps-2">{{ localize('active') }}</span>
                                    </div>
                                    <div>
                                        <input type="radio" name="status" value="0"
                                            {{ $top_breaking != null && $top_breaking->status == '0' ? 'checked' : '' }}><span
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
