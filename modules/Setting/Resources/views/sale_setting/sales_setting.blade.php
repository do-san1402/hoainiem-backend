@extends('setting::settings')
@section('title', localize('sale_settings'))
@push('css')
@endpush

@section('setting_content')

    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('sale_settings') }}</h6>
                </div>
            </div>
        </div>

        <form action="{{ route('sale.setting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" id="tax_url" value="{{ route('sale.setting.tax.get') }}">
                <div class="row mb-2">
                    <div class="col-md-4 col-12 pt-2">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('default_sale_discount') }}<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text">%</div>
                                <input type="text" required name="default_sales_discount"
                                    @if ($saleSetting != null) value="{{ $saleSetting->default_sales_discount }}" @endif
                                    class="form-control" id="autoSizingInputGroup" placeholder="0.00">
                            </div>
                            @if ($errors->has('default_sale_discount'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('default_sale_discount') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-2">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('default_sale_vat') }}</label>
                            <select tabindex="5" name="tax_setting_id" id="default_sale_tax" class="select-basic-single">
                                <option value="0" selected disabled>{{ localize('select_sale_vat') }}</option>
                                <option value="0" disabled class="text-center">{{ localize('taxes') }}</option>
                                @foreach ($allTax as $tax)
                                    @if ($tax->tax_type == 2)
                                        <option value="{{ $tax->id }}"
                                            @if ($saleSetting != null && $saleSetting->tax_setting_id == $tax->id) selected @endif>{{ $tax->tax_name }} -
                                            ({{ $tax->tax_percentage }}%)
                                        </option>
                                    @endif
                                @endforeach
                                <option value="0" disabled class="text-center">{{ localize('tax_group') }}</option>
                                @foreach ($allTax as $tax)
                                    @if ($tax->tax_type == 1)
                                        <option value="{{ $tax->id }}"
                                            @if ($saleSetting != null && $saleSetting->tax_setting_id == $tax->id) selected @endif>{{ $tax->tax_name }} -
                                            ({{ $tax->tax_percentage }}%)
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('tax_setting_id'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('tax_setting_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-2">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('sale_vat_setting') }}</label>
                            <select tabindex="5" name="sale_vat_setting" id="sale_vat_setting"
                                class="select-basic-single">
                                <option value="0" selected disabled>{{ localize('select_one') }}</option>
                                <option value="1" @if ($saleSetting != null && $saleSetting->sale_vat_setting == 1) selected @endif>
                                    {{ localize('vat_with_expenses') }}</option>
                                <option value="2" @if ($saleSetting != null && $saleSetting->sale_vat_setting == 2) selected @endif>
                                    {{ localize('vat_without_expenses') }}</option>
                            </select>
                            @if ($errors->has('sale_vat_setting'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('sale_vat_setting') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-2">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('sales_item_addition_method') }}</label>
                            <select tabindex="5" name="sale_item_addition_method" id="sale_item_addition_method"
                                class="select-basic-single">
                                <option value="1" @if ($saleSetting != null && $saleSetting->sale_item_addition_method == 1) selected @endif>
                                    {{ localize('add_item_in_new_row') }}</option>
                                <option value="2" @if ($saleSetting != null && $saleSetting->sale_item_addition_method == 2) selected @endif>
                                    {{ localize('increase_quantity_already_exists') }}</option>
                            </select>
                            @if ($errors->has('sales_item_addition_method'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('sales_item_addition_method') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-2">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('sale_submit_button_print_option') }}</label>
                            <select tabindex="5" name="sale_submit_button_print_option"
                                id="sale_submit_button_print_option" class="select-basic-single">
                                <option value="0" selected disabled>{{ localize('select_one') }}</option>
                                <option value="1" @if ($saleSetting != null && $saleSetting->sale_submit_button_print_option == 1) selected @endif>
                                    {{ localize('both_pos_a4') }}</option>
                                <option value="2" @if ($saleSetting != null && $saleSetting->sale_submit_button_print_option == 2) selected @endif>
                                    {{ localize('pos_only') }}</option>
                                <option value="3" @if ($saleSetting != null && $saleSetting->sale_submit_button_print_option == 3) selected @endif>
                                    {{ localize('a4_only') }}</option>
                            </select>
                            @if ($errors->has('sale_submit_button_print_option'))
                                <div class="error text-danger m-2">
                                    {{ $errors->first('sale_submit_button_print_option') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('allow_over_selling') }} <span
                                    title="@if ($saleSetting != null && $saleSetting->allow_over_selling == 1) Enabled products can be sold if they are not available on the stock.  @else Disabled products can't be sold if they are not available on the stock. @endif"><i
                                        class="fa fa-question-circle" aria-hidden="true"></i></span></label>

                            <div class="toggle-example">
                                <input name="allow_over_selling" @if ($saleSetting != null && $saleSetting->allow_over_selling == 1) checked @endif
                                    type="checkbox" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('multiple_payment') }}</label>
                            <div class="toggle-example">
                                <input name="multiple_payment" @if ($saleSetting != null && $saleSetting->multiple_payment == 1) checked @endif
                                    type="checkbox" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="terms_condition" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('daft_sale') }}</label>
                            <div class="toggle-example">
                                <input name="daft_sale" @if ($saleSetting != null && $saleSetting->daft_sale == 1) checked @endif type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for="sale_discount" class="form-check-label text-start ps-0 pb-1">
                                {{ localize('sale_discount') }}</label>
                            <div class="toggle-example">
                                <input name="sale_discount" @if ($saleSetting != null && $saleSetting->sale_discount == 1) checked @endif
                                    type="checkbox" data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                    data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('sale_dashboard') }}</label>
                            <div class="toggle-example">
                                <input type="checkbox" name="sale_dashboard"
                                    {{ $saleSetting != null && $saleSetting->sale_dashboard == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('sale_counter_daily_close') }}</label>
                            <div class="toggle-example">
                                <input type="checkbox" name="sale_counter_daily_close"
                                    {{ $saleSetting != null && $saleSetting->sale_counter_daily_close == 1 ? 'checked' : '' }}
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 col-12 pt-3">
                        <div class="form-group pe-2">
                            <label for=""
                                class="form-check-label text-start ps-0 pb-1">{{ localize('sales_terms_condition') }}</label>

                            <textarea name="terms_condition" class="form-control" rows="4">{{ $saleSetting->terms_condition }}</textarea>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-12 col-12 text-end">
                    <button type="submit" class="btn btn-primary">{{ localize('save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js')
    <script src="{{ module_asset('Setting/js/sale_setting.js') }}"></script>
@endpush
