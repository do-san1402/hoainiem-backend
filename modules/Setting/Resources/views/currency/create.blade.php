@extends('setting::settings')
@section('title', localize('create_currency'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('create_currency') }}</h6>
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
                    <form action="{{ route('currencies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    @input(['input_name' => 'title'])
                                </div>
                                <div class="col-md-12 mt-2">
                                    @input(['input_name' => 'symbol'])
                                </div>
                                <div class="form-group mb-2 mx-0 row">
                                    <label class="col-sm-3 col-form-label ps-0">{{ localize('country') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <select name="country_id" id="country_id"
                                            class="form-control {{ $errors->first('country_id') ? 'is-invalid' : '' }} mt-2">
                                            <option value="" selected disabled>{{ localize('select_one') }}</option>
                                            @foreach ($countries as $key => $country)
                                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country_id'))
                                            <div class="error text-danger">{{ $errors->first('country_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    @radio(['input_name' => 'status', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => 1])
                                </div>
                            </div>
                        </div>
                        <div class="card-footer form-footer text-start">
                            <button type="submit" class="btn btn-primary btn-sm ">{{ localize('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
