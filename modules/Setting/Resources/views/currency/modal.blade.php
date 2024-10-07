<div class="modal fade" id="addCurrencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="currency-form" action="{{ route('currencies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{ localize('add_currency') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="currency_id" id="currency-id">
                    @input(['input_name' => 'title', 'additional_id' => 'currency_title'])
                    @input(['input_name' => 'symbol', 'additional_id' => 'symbol'])

                    <div class="form-group mb-2 mx-0 row">
                        <label for="countries" class="col-sm-2 col-form-label ps-0">{{ localize('country') }}<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10 pe-0">
                            <select name="country_id" id="countries"
                                class="form-control {{ $errors->first('country_id') ? 'is-invalid' : '' }} form-control-sm basic-single">
                                <option value="">{{ localize('select_one') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <div class="error text-danger">{{ $errors->first('country_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-2 mx-0 row">
                        <label for="" class="col-sm-2 col-form-label ps-0">{{ localize('status') }}</label>
                        <div class="col-lg-10 pe-0">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" value="1"
                                    id="currency_status_active" checked>
                                <label for="currency_status_active"
                                    class="form-check-label">{{ localize('active') }}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" value="0"
                                    id="currency_status_inactive">
                                <label for="currency_status_inactive"
                                    class="form-check-label">{{ localize('inactive') }}</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ localize('reset') }}</button>
                    <button type="submit" id="currency-submit"
                        class="btn btn-primary">{{ localize('submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')

    <script src="{{ module_asset('Setting/js/currency.js') }}"></script>
@endpush
