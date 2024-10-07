@if (!empty($data->financial_year_id))

    <div class="row mt-3">
        <label for="academic_year_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('academicyear_academicyear') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="academic_year_id" class="search_test">
                @foreach ($foreignId['academicyearId'] as $academicyearvalue)
                    <option value="{{ $academicyearvalue->id }}"
                        {{ $data->financial_year_id == $academicyearvalue->id ? 'selected' : '' }}>
                        {{ $academicyearvalue->financial_year }}</option>
                @endforeach

            </select>

            @if ($errors->has('academic_year_id'))
                <div class="error text-danger m-2">{{ $errors->first('academic_year_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="academic_year_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('academicyear_academicyear') }}
            <span class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="academic_year_id" class="search_test" required>
                <option value="">None</option>
                @foreach ($foreignId['academicyearId'] as $academicyearvalue)
                    <option value="{{ $academicyearvalue->id }}">{{ $academicyearvalue->financial_year }}</option>
                @endforeach

            </select>

            @if ($errors->has('academic_year_id'))
                <div class="error text-danger m-2">{{ $errors->first('academic_year_id') }}</div>
            @endif
        </div>

    </div>


@endif
