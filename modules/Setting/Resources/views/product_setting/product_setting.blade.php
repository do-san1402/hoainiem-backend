@extends('setting::settings')
@section('title', localize('product_settings'))
@push('css')
@endpush

@section('setting_content')

    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')

    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('product_settings') }}</h6>
                </div>
            </div>
        </div>


        <div class="card-body">
            <form action="{{ route('product.setting.product.store') }}" method="POST" id="product_setting">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('brand') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->brand == 1) checked @endif name="brand" type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('model') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->model == 1) checked @endif name="model" type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('warranty') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->warranty == 1) checked @endif name="warranty" type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('product_price_update_when_purchase_or_sale') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->price_update == 1) checked @endif name="price_update" type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('category') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->category == 1) checked @endif name="category" type="checkbox"
                                    id="category" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 pt-3" id="sub_category">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('sub_category') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->sub_category == 1) checked @endif name="sub_category" type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('serial_number') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->serial_number == 1) checked @endif type="checkbox" name="serial_number"
                                    id="serial_number" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('mandatory_supplier') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->mandatory_supplier == 1) checked @endif type="checkbox"
                                    name="mandatory_supplier" id="mandatory_supplier" data-bs-toggle="toggle"
                                    data-on="Enable" data-off="Disable" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('product_expiry') }}</label>
                            <div class="toggle-example">
                                <input @if ($productSetting != null && $productSetting->product_expiry == 1) checked @endif type="checkbox"
                                    name="product_expiry" id="product_expiry" data-bs-toggle="toggle" data-on="Enable"
                                    data-off="Disable" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-12 pt-2" @if ($productSetting != null && $productSetting->product_expiry != 1) hidden @endif
                        id="on_product_expiry_main_div">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('on_product_expiry') }}</label>
                            <div class="d-flex">
                                <select tabindex="5" name="on_product_expiry" id="on_product_expiry"
                                    class="select-basic-single">
                                    <option value="0" disabled selected>{{ localize('on_product_expiry') }}
                                    </option>
                                    <option @if ($productSetting != null && $productSetting->on_product_expiry == 1) selected @endif value="1">Keep Selling
                                    </option>
                                    <option @if ($productSetting != null && $productSetting->on_product_expiry == 2) selected @endif value="2">Stop Selling
                                        n days before</option>
                                </select>
                                <input type="number" @if ($productSetting != null && $productSetting->on_product_expiry != 2) hidden @endif
                                    @if ($productSetting != null && $productSetting->n_days != 2) value="{{ $productSetting->n_days }}" @endif
                                    name="n_days" id="n_days" placeholder="0" class="form-control text-end">
                            </div>
                            @if ($errors->has('n_day'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('n_day') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 col-12 text-end">
                        <button class="btn btn-primary">{{ localize('save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ module_asset('Setting/js/product_setting.js') }}"></script>
@endpush
