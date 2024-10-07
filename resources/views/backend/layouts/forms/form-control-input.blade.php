<div class="form-group mb-2 mx-0 row">
    <label for="{{ $input_name }}" class="col-lg-3 col-form-label ps-0 label_{{ $input_name }}">
        @if (isset($label))
            {{ localize('' . $label) }}
        @else
            {{ localize('' . $input_name) }}
        @endif

        @if (isset($required))
            @if ($required == 'true')
                <span class="text-danger">*</span>
            @endif
        @else
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-lg-9">
        <input type="{{ isset($type) ? $type : 'text' }}" name="{{ $input_name }}"
            id="{{ isset($additional_id) ? $additional_id : 'field_' . $input_name }}"
            @if (isset($type) && $type == 'number') min="0" step="0.01" @endif
            value="{{ old($input_name) ? trim(old($input_name)) : (isset($value) ? trim($value) : '') }}"
            placeholder="@if (isset($label)) {{ localize($label) }}@else{{ localize($input_name) }} @endif"
            class="form-control {{ $errors->first($input_name) ? 'is-invalid' : '' }} {{ isset($additional_class) ? $additional_class : '' }}"
            aria-describedby="emailHelp" {{ isset($custom_string) ? $custom_string : '' }} autocomplete="off"
            {{ isset($accept) ? 'accept=' . $accept . '' : '' }} {{ isset($disabled) ? 'disabled' : '' }} />

        @if (isset($tooltip))
            <small id="emailHelp" class="form-text text-muted">{{ $tooltip }}</small>
        @endif

        @if ($errors->has($input_name))
            <div class="error text-danger text-start">{{ $errors->first($input_name) }}</div>
        @endif
    </div>
</div>
