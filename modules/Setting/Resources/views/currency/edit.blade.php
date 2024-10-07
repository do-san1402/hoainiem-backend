@extends('setting::settings')
@section('title', localize('edit_currency'))
@section('setting_content')
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('edit_currency') }}</h6>
                            </div>
                            <div class="text-end">
                                <div class="actions">
                                    @can('read_currency')
                                        <a href="{{ route('currencies.index') }}" class="btn btn-success btn-sm"><i
                                                class="fa fa-list"></i>&nbsp{{ localize('currency_list') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('currencies.update', $currency->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        @input(['input_name' => 'title', 'value' => $currency->title])
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        @input(['input_name' => 'symbol', 'value' => $currency->symbol])
                                    </div>
                                    <div class="form-group mb-2 mx-0 row">
                                        <label class="col-sm-3 col-form-label ps-0">{{ localize('country') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <select name="country_id" id="country_id"
                                                class="form-control {{ $errors->first('country_id') ? 'is-invalid' : '' }} mt-2">
                                                <option value="" selected disabled>{{ localize('select_one') }}
                                                </option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $currency->country_id ? 'selected' : '' }}>
                                                        {{ $country->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <div class="error text-danger">{{ $errors->first('country_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mt-5">
                                            <div class="row">
                                                <div class="col-md-3 text-start">
                                                    <label>{{ localize('status') }}</label>
                                                </div>
                                                <div class="col-md-5 text-start">
                                                    <div class="me-3">
                                                        <input type="radio" name="status" value="1"
                                                            {{ $currency->status == '1' ? 'checked' : '' }}> <span
                                                            class="ps-2">{{ localize('active') }}</span>
                                                    </div>
                                                    <div>
                                                        <input type="radio" name="status" value="0"
                                                            {{ $currency->status == '0' ? 'checked' : '' }}><span
                                                            class="ps-2">{{ localize('inactive') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer form-footer text-start">
                            <button type="submit" class="btn btn-primary btn-sm ">{{ localize('update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
