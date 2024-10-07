@if (!empty($data->inventory_customer_id))

    <div class="row mt-3">
        <label for="inventory_customer_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('customer_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="inventory_customer_id" class="form-select" required>
                @foreach ($foreignId['customerId'] as $customervalue)
                    <option value="{{ $customervalue->id }}"
                        {{ $data->inventory_customer_id == $customervalue->id ? 'selected' : '' }}>
                        {{ $customervalue->customer_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('inventory_customer_id'))
                <div class="error text-danger m-2">{{ $errors->first('inventory_customer_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="inventory_customer_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('customer_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="inventory_customer_id" class="form-select" required>
                <option value="">None</option>
                @foreach ($foreignId['customerId'] as $paymehtodvalue)
                    <option value="{{ $paymehtodvalue->id }}">{{ $paymehtodvalue->customer_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('inventory_customer_id'))
                <div class="error text-danger m-2">{{ $errors->first('inventory_customer_id') }}</div>
            @endif
        </div>

    </div>

@endif
