<div class="row">

    <label for="bed_no"
        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('status') }}</label>
    <div class="col-sm-9 col-md-12 col-xl-9 mt-2">

        <input class="form-check-input " type="radio" name="is_active" value="1" id="is_active"
            {{ $data->is_active == 1 ? 'checked' : '' }}>
        <label class="form-check-label " for="is_active">
            {{ localize('active') }}
        </label>

        <input class="form-check-input " type="radio" name="is_active" value="0" id="is_active"
            {{ $data->is_active == 0 ? 'checked' : '' }}>
        <label class="form-check-label " for="is_active">
            {{ localize('disable') }}
        </label>

    </div>


</div>
