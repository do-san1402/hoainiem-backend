@if (!empty($data->branch_id))


    <div class="row mt-3">
        <label for="branch_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('branch_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="branch_id" class="form-select" required>

                @foreach ($foreignId['branchId'] as $branchvalue)
                    <option value="{{ $branchvalue->id }}" {{ $data->branch_id == $branchvalue->id ? 'selected' : '' }}>
                        {{ $branchvalue->branch_name }}
                    </option>
                @endforeach

            </select>

            @if ($errors->has('branch_id'))
                <div class="error text-danger m-2">{{ $errors->first('branch_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="branch_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('branch_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="branch_id" class="form-select" required>
                <option value="">None</option>
                @foreach ($foreignId['branchId'] as $branchvalue)
                    <option value="{{ $branchvalue->id }}">{{ $branchvalue->branch_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('branch_id'))
                <div class="error text-danger m-2">{{ $errors->first('branch_id') }}</div>
            @endif
        </div>

    </div>
@endif
