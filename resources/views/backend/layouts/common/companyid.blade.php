@if (!empty($data->company_id))



    <div class="row mt-3">
        <label for="company_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('company_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="company_id" class="search_test" required>

                @foreach ($foreignId['companyId'] as $companyvalue)
                    <option value="{{ $companyvalue->id }}"
                        {{ $data->company_id == $companyvalue->id ? 'selected' : '' }}>
                        {{ $companyvalue->institute_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('company_id'))
                <div class="error text-danger m-2">{{ $errors->first('company_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="company_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('company_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="company_id" class="search_test" required>

                @foreach ($foreignId['companyId'] as $companyvalue)
                    <option value="{{ $companyvalue->id }}">{{ $companyvalue->institute_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('company_id'))
                <div class="error text-danger m-2">{{ $errors->first('company_id') }}</div>
            @endif
        </div>
    </div>
@endif
