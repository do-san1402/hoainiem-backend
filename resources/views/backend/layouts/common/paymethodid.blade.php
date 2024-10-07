@if (!empty($data->paymethod_id))

    <div class="row mt-3">
        <label for="paymethod_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('pay_method_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="paymethod_id" class="form-select" required>
                @foreach ($foreignId['paymethodId'] as $paymehtodvalue)
                    <option value="{{ $paymehtodvalue->id }}"
                        {{ $data->paymethod_id == $paymehtodvalue->id ? 'selected' : '' }}>
                        {{ $paymehtodvalue->paymethod_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('paymethod_id'))
                <div class="error text-danger m-2">{{ $errors->first('paymethod_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="paymethod_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('pay_method_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="paymethod_id" class="form-select" required>
                <option value="">None</option>
                @foreach ($foreignId['paymethodId'] as $paymehtodvalue)
                    <option value="{{ $paymehtodvalue->id }}">{{ $paymehtodvalue->paymethod_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('paymethod_id'))
                <div class="error text-danger m-2">{{ $errors->first('paymethod_id') }}</div>
            @endif
        </div>

    </div>

@endif
