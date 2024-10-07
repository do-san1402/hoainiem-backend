<div class="form-group mb-2 mx-0 row">
    <label for="{{ $input_name }}" class="col-md-3 col-form-label p-0 label_{{ $input_name }}">
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

    <div class="col-md-9">
        <textarea name="{{ $input_name }}" id="{{ $input_name }}" rows="{{ @$row ? $row : 3 }}"
            placeholder="{{ isset($placeholder) == null ? localize('' . $input_name) : $placeholder }}"
            class="form-control {{ $errors->first($input_name) ? 'is-invalid' : '' }} {{ isset($additional_class) ? $additional_class : '' }}"
            aria-describedby="emailHelp" {{ isset($custom_string) ? $custom_string : '' }}>{{ isset($value) ? $value : old($input_name) }}</textarea>

        @if ($errors->has($input_name))
            <div class="error text-danger">{{ $errors->first($input_name) }}</div>
        @endif
    </div>
</div>
