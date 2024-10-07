@extends('setting::settings')
@section('title', localize('invoice_theme_settings'))
@section('setting_content')
    @include('backend.layouts.common.validation')
    <div class="card mb-4 border">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('invoice_theme_settings') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('invoice.setting.update') }}" method="POST" enctype="multipart/form-data"
                id="invoice-setting">
                @csrf

                {{-- <div class="row mb-2">
                    @php
                        $sl = 1;
                    @endphp
                    @foreach ($invoiceSettings as $item)
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group pe-2 form-check form-check-inline radio-toolbar">
                                <label for=""
                                    class="col-form-label text-start pb-1 mb-2">{{ ucwords($item->title) }}</label>
                                <div class="mb-2 {{ $item->default == 1 ? 'image-overlay' : '' }}">
                                    <img src="{{ asset('backend/invoice/assets/image/' . $item->image) }}"
                                        class="img-fluid img-thumbnail" alt="Invoice Theme" height="500">
                                </div>
                                <input type="radio" id="theme-{{ $item->id }}" class="form-check-input" name="default"
                                    value="{{ $item->id }}" {{ $item->default == 1 ? 'checked' : '' }}>
                                <label for="theme-{{ $item->id }}"
                                    class="col-form-label theme-active">{{ localize('active') }}</label>
                            </div>
                            @php
                                $sl++;
                            @endphp
                        </div>
                    @endforeach

                    <div class="col-md-12 col-12 text-end">
                        <button class="btn btn-success submit_button">{{ localize('save') }}</button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
@endsection


@push('js')
@endpush
