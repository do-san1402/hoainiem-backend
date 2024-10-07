@extends('backend.layouts.app')
@section('title', localize('contact_settings'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('contact_settings') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="projectDetailsNonModalForm" action="{{ route('view_setup.contact_page_setup_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="editor"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('editor_name')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="editor" name="editor"
                                        placeholder="{{ ucwords(localize('editor_name')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->editor:null}}">
                                </div>

                                @if ($errors->has('editor'))
                                    <div class="error text-danger m-2">{{ $errors->first('editor') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="content"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('content')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="content" name="content"
                                        placeholder="{{ ucwords(localize('content')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->content:null}}">
                                </div>

                                @if ($errors->has('content'))
                                    <div class="error text-danger m-2">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="address"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('address')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="{{ ucwords(localize('address')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->address:null}}">
                                </div>

                                @if ($errors->has('address'))
                                    <div class="error text-danger m-2">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="phone"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('phone')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="number" class="form-control" id="phone" name="phone"
                                        placeholder="{{ ucwords(localize('phone')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->phone:null}}">
                                </div>

                                @if ($errors->has('phone'))
                                    <div class="error text-danger m-2">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="phone_two"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('phone_two')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="number" class="form-control" id="phone_two" name="phone_two"
                                        placeholder="{{ ucwords(localize('phone_two')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->phone_two:null}}">
                                </div>

                                @if ($errors->has('phone_two'))
                                    <div class="error text-danger m-2">{{ $errors->first('phone_two') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="email"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('email')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="{{ ucwords(localize('email')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->email:null}}">
                                </div>

                                @if ($errors->has('email'))
                                    <div class="error text-danger m-2">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="website"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('website')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="website" name="website"
                                        placeholder="{{ ucwords(localize('website')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->website:null}}">
                                </div>

                                @if ($errors->has('website'))
                                    <div class="error text-danger m-2">{{ $errors->first('website') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="latitude"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('latitude_and_longitude')) }}</label>
                                <div class="col-sm-5 col-md-6 col-xl-5">
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                        placeholder="{{ ucwords(localize('latitude')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->latitude:null}}">
                                </div>

                                <div class="col-sm-4 col-md-6 col-xl-4">
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                        placeholder="{{ ucwords(localize('longitude')) }}" value="{{$contact_setting_page != null ? $contact_setting_page->longitude:null}}">
                                </div>

                                @if ($errors->has('latitude'))
                                    <div class="error text-danger m-2">{{ $errors->first('latitude') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="map"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('map')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                <textarea class="form-control" name="map">{{$contact_setting_page != null ? $contact_setting_page->map:null}}</textarea>
                                        <span>{{localize('Embed a map SRC Url')}}</span>
                                </div>

                                @if ($errors->has('map'))
                                    <div class="error text-danger m-2">{{ $errors->first('map') }}</div>
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
