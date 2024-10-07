<div class="form-group">
    <div class="upload-img-box">
        @if (isset($preview_image) && !empty($preview_image))
            <img src="{{ asset('storage/' . $preview_image) }}" alt="Upload File" style="width:100%">
        @else
            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Upload File" style="width:100%">
        @endif

        <input type="file" name="{{ $input_name }}" id="{{ $input_name }}" accept="image/*"
            onchange="previewFile(this)">

        <div class="upload-img-box-icon">
            <i class="fa fa-camera"></i>
            <p class="m-0">
                @if (isset($label))
                    {{ $label }}
                @else
                    {{ localize('' . $input_name) }}
                @endif
            </p>
        </div>
    </div>
    @if ($errors->has($input_name))
        <div class="error text-danger">{{ $errors->first($input_name) }}</div>
    @endif
</div>
