<div class="card-body p-1">
    <div class="row mb-2">
        <div class="form-group">
            <label for="date" class="col-form-label fw-semibold">{{ localize('device_id') }}<span
                    class="text-danger">*</span></label>
            <input class="form-control" type="text" name="device_id" id="device_id" />

            @if ($errors->has('device_id'))
                <div class="error text-danger m-2">
                    {{ $errors->first('device_id') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="date" class="col-form-label fw-semibold">{{ localize('ip_address') }}<span
                    class="text-danger">*</span></label>
            <input class="form-control" type="text" name="ip_address" id="ip_address" />

            @if ($errors->has('ip_address'))
                <div class="error text-danger m-2">
                    {{ $errors->first('ip_address') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="date" class="col-form-label fw-semibold">{{ localize('status') }}<span
                    class="text-danger">*</span></label>
            <select name="status" class="select-basic-single" id="machine_status">
                <option value="" selected disabled> {{ localize('select_one') }} </option>
                <option value="1">{{ localize('active') }}</option>
                <option value="0">{{ localize('inactive') }}</option>
            </select>

            @if ($errors->has('status'))
                <div class="error text-danger m-2">
                    {{ $errors->first('status') }}</div>
            @endif
        </div>
    </div>
</div>

{{-- <script src="{{ module_asset('Setting/js/zkt.js') }}"></script> --}}

