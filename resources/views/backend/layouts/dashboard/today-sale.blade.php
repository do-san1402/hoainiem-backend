@push('css')
@endpush
<div class="col-sm-6 col-lg-4 col-xl-3 placeholder" id="todayAndYesterdaySales"
    data-url="{{ route('todayAndYesterdaySales') }}">
    <div class="animated-background"></div>
    <div class="p-2 bg-white rounded p-3 shadow-1" hidden>
        <div class="d-flex align-items-center height-85">
            <div class="me-3">
                <img class="h_70" src="{{ asset('backend/assets/dist/img/today-sale.png') }}" alt="" />
            </div>
            <div>
                <p class="mb-1 fw-semi-bold">Today Sale</p>
                <h4 class="fw-bold mb-1" id="todaySales"></h4>
                <p class="mb-0 fw-semi-bold">Yesterday Sale : <span class="text-success" id="yesterdaySales"></span></p>
            </div>
        </div>
    </div>
</div>
