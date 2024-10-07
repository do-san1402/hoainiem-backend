@push('css')
@endpush
<div class="col-sm-6 col-lg-4 col-xl-3 placeholder" id="purchaseDue" data-url="{{ route('purchaseDue') }}">
    <div class="animated-background"></div>
    <div class="p-2 bg-white rounded p-3 shadow-1" hidden>
        <div class="d-flex align-items-center height-85">
            <div class="me-3">
                <img class="h_70" src="{{ asset('backend/assets/dist/img/purchase-due.png') }}" alt="" />
            </div>
            <div>
                <p class="mb-1 fw-semi-bold">Purchase Due</p>
                <h4 class="fw-bold mb-1"></h4>
            </div>
        </div>
    </div>
</div>
