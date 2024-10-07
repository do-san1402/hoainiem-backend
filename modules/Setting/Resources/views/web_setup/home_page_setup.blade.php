@extends('backend.layouts.app')
@section('title', localize('home_page_view_setting'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('home_page_view_setting') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="table_customize">

                <form id="homePageSettingsFormSave" action="{{ route('view_setup.save_home_page_settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row ps-4 pe-4">

                        <div class="col-md-6 mt-3">
                            <div class="row">
                                <label for="position_no"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('position_no')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="position_no" id="position_no" class="form-control select-basic-single">
                                        <option value="">{{ ucwords(localize('select_position')) }}</option>
                                        @for ($i = 1; $i <= 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                @if ($errors->has('position_no'))
                                    <div class="error text-danger m-2">{{ $errors->first('position_no') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="row">
                                <label for="category_name"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ ucwords(localize('category_name')) }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="category_name" id="category_name" class="form-control select-basic-single">
                                        <option value="">{{ ucwords(localize('select_category')) }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($errors->has('category_name'))
                                    <div class="error text-danger m-2">{{ $errors->first('category_name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2 mt-3">
                            <button type="submit" class="btn btn-primary me-2"></i>{{ ucwords(localize('add_position')) }}</button>
                        </div>

                    </div>

                </form>

                <br><br>

                <form id="homePageSettingsFormUpdate" action="{{ route('view_setup.home_page_setup_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="ps-4 pe-4">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>{{ localize('position_id') }}</th>
                                <th>{{ localize('category_name') }}</th>
                                <th>{{ localize('status') }}</th>
                            </tr>

                            @foreach ($home_page_settings ?? [] as $value1)
                                @php
                                    $key1 = $loop->iteration;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="hidden" value="{{ $key1}}" name="position_no[]">
                                        {{ $key1}}
                                    </td>
                                    <td>
                                        <select name="category_id[{{ $key1 }}]" class="form-control select-basic-single" required="1">
                                            <option value="">{{ localize('category_name') }}</option>
                                            @foreach ($categories as $key => $value)
                                                <option value="{{ $value->id }}" {{ $value->id == $value1->category_id ? 'selected' : '' }}>
                                                    {{ $value->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="status[{{ $key1 }}]" value="0">
                                        <input type="checkbox" name="status[{{ $key1 }}]" {{ $value1->status == 1 ? 'checked' : '' }} value="1">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                       <div>
                            <button type="submit" class="btn btn-success me-2"></i>{{ localize('update') }}</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection

@push('js')

    <script src="{{ module_asset('Setting/js/home_page_settings.js') }}"></script>

@endpush
