@extends('setting::settings')
@section('title', localize('tax_settings'))
@section('setting_content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('tax_settings') }}</h6>
                </div>
            </div>
        </div>
        <form action="{{ route('sale.setting.tax.store') }}" method="POST" id="tax_store">
            @csrf
            <div class="card-body">
                <div class="table-responsive mt-4 table_customize">
                    <table class="table table-bordered text-end">
                        <thead>
                            <tr>
                                <th class="text-start">{{ localize('tax_name') }}<span class="text-danger">*</span></th>
                                <th>{{ localize('tax_number') }}<span class="text-danger">*</span></th>
                                <th>{{ localize('tax_percentage') }}<span class="text-danger">*</span></th>
                                <th width="5%">{{ localize('action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="addTaxSetting" data-count="{{ $count }}">
                            @if (count($taxes) > 0)
                                @foreach ($taxes as $key => $tax)
                                    <tr>
                                        <td class="text-start">
                                            <input type="text" required name="tax_name[]"
                                                id="tax_name_{{ $key + 1 }}" value="{{ $tax->tax_name }}" required
                                                class="form-control text-start" placeholder="{{ localize('tax_name') }}" />
                                        </td>
                                        <td class="text-end">
                                            <input type="text" required name="tax_number[]"
                                                value="{{ $tax->tax_number }}" id="tax_number{{ $key + 1 }}" required
                                                class="form-control text-end" placeholder="{{ localize('tax_number') }}" />
                                        </td>
                                        <td class="text-end">
                                            <input type="text" required name="tax_percentage[]"
                                                id="tax_percentage{{ $key + 1 }}" value="{{ $tax->tax_percentage }}"
                                                required class="form-control text-end"
                                                placeholder="{{ localize('tax_percentage') }}" />
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-end" type="button"
                                                onclick="deleteRow(this)"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-start">
                                        <input type="text" required name="tax_name[]" id="tax_name_1" required
                                            class="form-control text-start" placeholder="{{ localize('tax_name') }}" />
                                    </td>
                                    <td class="text-end">
                                        <input type="text" required name="tax_number[]" value="6126818427"
                                            id="tax_number_1" required class="form-control text-end"
                                            placeholder="{{ localize('tax_number') }}" />
                                    </td>
                                    <td class="text-end">
                                        <input type="text" required name="tax_percentage[]" id="tax_percentage_1"
                                            required class="form-control text-end"
                                            placeholder="{{ localize('tax_percentage') }}" />
                                    </td>
                                    <td>
                                        <button class="btn btn-danger text-end" type="button" onclick="deleteRow(this)"><i
                                                class="fa fa-close"></i></button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-info"
                                        onClick="addTaxSettingField('addTaxSetting')">
                                        <i class="fa fa-plus text-white"></i>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 col-12 text-end">
                        <button class="btn btn-success" type="submit">{{ localize('save') }}</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('tax_group') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <button onclick="addGroupTax()" class="btn btn-success btn-sm"><i
                                class="fa-sharp fa-solid fa-circle-plus"></i>
                            {{ localize('add_new_tax_group') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mt-4 table_customize">
                {{ $dataTable->table() }}
            </div>
        </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addGroupTaxModal" tabindex="-1" aria-labelledby="addGroupTaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('sale.tax.group.store') }}" method="POST" id="saveGroupTax">
                    @csrf
                    <input type="hidden" value="{{ route('sale.setting.tax.for.group') }}" id="getTaxSettingUrl">
                    <input type="hidden" name="tax_group_id" id="tax_group_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGroupTaxModalLabel">{{ localize('add_group_tax') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="address" class="col-form-label fw-semibold">
                                        {{ localize('tax_group_name') }}</label>
                                    <input type="text" class="form-control" name="tax_group_name" id="tax_group_name"
                                        placeholder="{{ localize('tax_group_name') }}" required>
                                    @if ($errors->has('tax_group_name'))
                                        <div class="error text-danger m-2">
                                            {{ $errors->first('tax_group_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="address" class="col-form-label fw-semibold">
                                        {{ localize('tax') }}</label>
                                    <select multiple="multiple" name="tax_setting_id[]" id="tax_setting_id"
                                        class="form-control" required>
                                    </select>
                                    @if ($errors->has('tax'))
                                        <div class="error text-danger m-2">
                                            {{ $errors->first('tax') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger-soft me-2"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                        <button type="submit" class="btn btn-success">{{ localize('submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Setting/js/tax_setting.js') }}"></script>
@endpush
