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

    <div class="col-lg-9 text-start {{ isset($additional_class) ? $additional_class : '' }}">
        @foreach ($data_set as $key => $_data)
            <div class="form-check ">
                <input type="radio" id="{{ $input_name }}{{ $_data }}" class="form-check-input"
                    name="{{ $input_name }}" value="{{ $key }}"
                    @if (isset($value) && $value == $key) checked @endif>
                <label for="{{ $input_name }}{{ $_data }}" class="form-check-label"> {{ $_data }}
                </label>
            </div>
        @endforeach
    </div>
    @if ($errors->has($input_name))
        <div class="error text-danger">{{ $errors->first($input_name) }}</div>
    @endif
</div>
