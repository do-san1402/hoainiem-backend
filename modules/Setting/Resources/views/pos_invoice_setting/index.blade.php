@extends('setting::settings')
@section('title', localize('invoice_settings'))
@push('css')
@endpush

@section('setting_content')

    @include('backend.layouts.common.validation')

    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('invoice_settings') }}</h6>
                </div>
            </div>
        </div>


        <form action="{{ route('pos_invoice.setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <div class="form-group pe-2">
                            <label class="text-start ps-0 pb-1">{{ localize('show_vat') }}</label>

                            <div class="toggle-example">
                                <input name="vat" @if ($posInvoiceSetting != null && $posInvoiceSetting->vat == 1) checked @endif type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="form-group pe-2">
                            <label class="text-start ps-0 pb-1">{{ localize('show_subtotal') }}</label>

                            <div class="toggle-example">
                                <input name="subtotal" @if ($posInvoiceSetting != null && $posInvoiceSetting->subtotal == 1) checked @endif type="checkbox"
                                    data-bs-toggle="toggle" data-on="Enable" data-off="Disable" data-onstyle="success"
                                    data-offstyle="danger">
                            </div>
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
@endpush
