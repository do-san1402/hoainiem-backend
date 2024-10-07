@extends('setting::settings')
@section('title', localize('purchase_settings'))
@push('css')
@endpush

@section('setting_content')

    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')

    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('purchase_settings') }}</h6>
                </div>
            </div>
        </div>

        <form action="{{ route('purchase.setting.purchase.store') }}" method="POST" id="purchase_setting">
            @csrf
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('purchase_item_addition_method') }}</label>
                            <select name="purchase_item_addition_method" id="purchase_item_addition_method"
                                class="select-basic-single">
                                <option value="1" @if ($purchaseSetting != null && $purchaseSetting->purchase_item_addition_method == 1) selected @endif>
                                    {{ localize('add_item_in_new_row') }}</option>
                                <option value="2" @if ($purchaseSetting != null && $purchaseSetting->purchase_item_addition_method == 2) selected @endif>
                                    {{ localize('increase_quantity_already_exists') }}</option>
                            </select>
                            @if ($errors->has('purchase_item_addition_method'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('purchase_item_addition_method') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('print_type') }}</label>
                            <select name="print_type" id="print_type" class="select-basic-single">
                                <option value="1" @if ($purchaseSetting != null && $purchaseSetting->print_type == 1) selected @endif>
                                    {{ localize('no_print') }}</option>
                                <option value="2" @if ($purchaseSetting != null && $purchaseSetting->print_type == 2) selected @endif>
                                    {{ localize('a4_size_print') }}</option>
                                <option value="3" @if ($purchaseSetting != null && $purchaseSetting->print_type == 3) selected @endif>
                                    {{ localize('pos_print') }}</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('editing_product_price') }} <i class="fa fa-info-circle text-info"
                                    title="If enabled product purchase price and selling price will be updated after a purchase is added or updated"></i></label>
                            <div class="toggle-example">
                                <input @if ($purchaseSetting != null && $purchaseSetting->editing_product_price == 1) checked @endif name="editing_product_price"
                                    type="checkbox" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3" id="purchase_requisition">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('purchase_requisition') }} <i class="fa fa-info-circle text-info"
                                    title="A purchase requisition is a document that an employee creates to request a purchase of goods or services."></i></label>
                            <div class="toggle-example">
                                <input type="checkbox" name="purchase_requisition"
                                    {{ $purchaseSetting != null && $purchaseSetting->purchase_requisition == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('lot_number') }} <i class="fa fa-info-circle text-info"
                                    title="This will enable you to enter Lot number for each purchase line in purchase screen"></i></label>
                            <div class="toggle-example">
                                <input type="checkbox" name="lot_number"
                                    {{ $purchaseSetting != null && $purchaseSetting->lot_number == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('purchase_dashboard') }}</label>
                            <div class="toggle-example">
                                <input type="checkbox" name="purchase_dashboard"
                                    {{ $purchaseSetting != null && $purchaseSetting->purchase_dashboard == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('purchase_order') }} <i class="fa fa-info-circle text-info"
                                    title="A purchase order is a commercial document and first official offer issued by a buyer to a seller indicating types, quantities, and agreed prices for products or services. It is used to control the purchasing of products and services from external suppliers.Purchase orders can be an essential part of enterprise resource planning system orders."></i></label>
                            <div class="toggle-example">
                                <input type="checkbox" id="purchase_order" name="purchase_order"
                                    {{ $purchaseSetting != null && $purchaseSetting->purchase_order == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3" id="purchase_status_div">
                        <div class="form-group pe-2">
                            <label for="" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('purchase_status') }} <i class="fa fa-info-circle text-info"
                                    title="On disable all purchases will be marked as Item Received"></i></label>
                            <div class="toggle-example purchase_status_toggle">
                                <input type="checkbox" name="purchase_status" id="purchase_status"
                                    {{ $purchaseSetting != null && $purchaseSetting->purchase_status == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('purchase_qrcode') }}</label>
                            <div class="toggle-example">
                                <input type="checkbox" name="purchase_qrcode"
                                    {{ $purchaseSetting != null && $purchaseSetting->purchase_qrcode == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('purchase_terms_condition') }}</label>

                            <textarea name="terms_condition" class="form-control" rows="4">{{ $purchaseSetting->terms_condition }}</textarea>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-12 col-12">
                    <button class="btn btn-primary">{{ localize('save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js')
    <script src="{{ module_asset('Setting/js/purchase_setting.js') }}"></script>
@endpush
