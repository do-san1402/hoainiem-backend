@extends('backend.layouts.app')
@section('title', localize('dashboard'))
@push('css')
    <style>
        #stock-alert-product-table_wrapper .row .col-md-4 {
            width: 50%;
        }

        #stock-alert-product-table_wrapper .row .col-md-4:nth-child(2) {
            display: none;
        }

        #low-stock-alert-product-table_wrapper .row .col-md-4 {
            width: 50%;
        }

        #low-stock-alert-product-table_wrapper .row .col-md-4:nth-child(2) {
            display: none;
        }
    </style>
@endpush
@section('content')

    @include('backend.layouts.common.message')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-18 fw-bold mb-0">Welcome , {{ auth()->user() ? ucwords(auth()->user()->full_name) : '' }}
                    </h6>
                </div>
                <div class="text-end">
                    <div id="filterrange" class="d-flex align-items-center predefined bg-solitude border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 19"
                            fill="none">
                            <path
                                d="M6.29628 19C6.20409 19 6.11181 18.9774 6.02723 18.9316C5.8376 18.8289 5.71891 18.6267 5.71891 18.4062V11.0306L0.135319 4.19742C0.0479254 4.09044 0 3.95514 0 3.8154V0.59375C0 0.265854 0.258515 0 0.577361 0H16.4226C16.7415 0 17 0.265854 17 0.59375V3.8154C17 3.95514 16.9521 4.09044 16.8647 4.19742L11.2811 11.0306V15.2956C11.2811 15.4913 11.1873 15.6745 11.0305 15.7852L6.62301 18.8958C6.525 18.9649 6.41083 19 6.29628 19ZM1.15472 3.59903L6.73832 10.4322C6.82571 10.5392 6.87364 10.6745 6.87364 10.8142V17.2787L10.1264 14.983V10.8142C10.1264 10.6745 10.1743 10.5392 10.2617 10.4322L15.8453 3.59903V1.1875H1.15472V3.59903Z"
                                fill="black" />
                        </svg>
                        <span id="filterDates" class="date-arange pt-0"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">

                @include('backend.layouts.dashboard.today-sale')
                @include('backend.layouts.dashboard.total-sale')
                @include('backend.layouts.dashboard.stock-valuations')
                @include('backend.layouts.dashboard.invoice-due')
                @include('backend.layouts.dashboard.sales-return')
                @include('backend.layouts.dashboard.total-expense')
                @include('backend.layouts.dashboard.purchase-return')
                @include('backend.layouts.dashboard.purchase-due')

                @include('backend.layouts.dashboard.income-vs-expense')
                @include('backend.layouts.dashboard.bank-account')
                @include('backend.layouts.dashboard.counterWiseSale')
                @include('backend.layouts.dashboard.cashier-wise-sale')
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="{{ asset('backend/assets/dist/js/dashboard.js') }}"></script>
@endpush
