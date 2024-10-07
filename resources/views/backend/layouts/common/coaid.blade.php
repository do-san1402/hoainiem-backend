@if (!empty($data->coa_id))


    <div class="mb-3">
        <label for="coa_id" class="form-label">{{ localize('account_coa') }}</label>
        <select name="coa_id" class="search_test">

            @foreach ($foreignId['coaId'] as $coavalue)
                <option value="{{ $coavalue->id }}" {{ $data->coa_id == $coavalue->id ? 'selected' : '' }}>
                    {{ $coavalue->name }}</option>
            @endforeach

        </select>

        @if ($errors->has('coa_id'))
            <div class="error text-danger m-2">{{ $errors->first('coa_id') }}</div>
        @endif
    </div>
@else
    <div class="mb-3">
        <label for="coa_id" class="form-label">{{ localize('account_coa') }}</label>
        <select name="coa_id" class="search_test">

            @foreach ($coaIds as $coavalue)
                <option value="{{ $coavalue->id ?? 1 }}">{{ $coavalue->name ?? '' }}</option>
            @endforeach

        </select>

        @if ($errors->has('coa_id'))
            <div class="error text-danger m-2">{{ $errors->first('coa_id') }}</div>
        @endif
    </div>

@endif
