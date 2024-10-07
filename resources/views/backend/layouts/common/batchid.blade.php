@if (!empty($data->batch_id))


    <div class="row mt-3">
        <label for="batch_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('branch_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="batch_id" class="search_test" required>

                @foreach ($foreignId['batchId'] as $batchvalue)
                    <option value="{{ $batchvalue->id }}" {{ $data->batch_id == $batchvalue->id ? 'selected' : '' }}>
                        {{ $batchvalue->batch_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('batch_id'))
                <div class="error text-danger m-2">{{ $errors->first('batch_id') }}</div>
            @endif
        </div>

    </div>
@else
    <div class="row mt-3">
        <label for="batch_id"
            class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">{{ localize('batch_name') }}<span
                class="text-danger">*</span></label>
        <div class="col-sm-9 col-md-12 col-xl-9">
            <select name="batch_id" class="search_test" required>
                <option value="">None</option>
                @foreach ($foreignId['batchId'] as $batchvalue)
                    <option value="{{ $batchvalue->id }}">{{ $batchvalue->batch_name }}</option>
                @endforeach

            </select>

            @if ($errors->has('batch_id'))
                <div class="error text-danger m-2">{{ $errors->first('batch_id') }}</div>
            @endif
        </div>

    </div>
@endif
