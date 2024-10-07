<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6 p-4">
                <legend>{{ localize_uc('thumb_image_size') }}</legend>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="thumb_height" class="col-form-label fw-semibold">
                            {{ localize_uc('height') }}
                            ({{ localize_uc('Y') }})
                            <span class="text-danger">*</span> </label>
                        <input type="number" name="thumb_height" id="thumb_height"
                            class="form-control @error('thumb_height') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_thumb_height') }}" value="{{ old('thumb_height', 280) }}"
                            required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('thumb_height')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="thumb_width" class="col-form-label fw-semibold">
                            {{ localize_uc('width') }}
                            ({{ localize_uc('x') }})
                            <span class="text-danger">*</span> </label>
                        <input type="number" name="thumb_width" id="thumb_width"
                            class="form-control @error('thumb_width') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_thumb_width') }}" value="{{ old('thumb_width', 400) }}"
                            required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('thumb_width')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <legend>{{ localize_uc('large_image_size') }}</legend>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="large_height" class="col-form-label fw-semibold">
                            {{ localize_uc('height') }}
                            ({{ localize_uc('Y') }})
                            <span class="text-danger">*</span> </label>
                        <input type="number" name="large_height" id="large_height"
                            class="form-control @error('large_height') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_large_height') }}"
                            value="{{ old('large_height', 451) }}" required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('large_height')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="large_width" class="col-form-label fw-semibold">
                            {{ localize_uc('width') }}
                            ({{ localize_uc('x') }})
                            <span class="text-danger">*</span> </label>
                        <input type="number" name="large_width" id="large_width"
                            class="form-control @error('large_width') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_large_width') }}" value="{{ old('large_width', 643) }}"
                            required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('large_width')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="col-lg-12 col-xs-12 ">
            <div class="form-group">
                <label>{{ localize('image') }} <span class="text-danger">*</span></label>
                <input type="file" accept="image/*" name="image"
                    class="form-control file-preview @error('image') is-invalid @enderror"
                    data-previewDiv="preview_file_image" required />
                <div class="text-warning m-2">
                    * {{ localize_uc('file_size_max_3_mb') }}
                </div>
                <div class="invalid-feedback error text-danger m-2">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
                <div id="preview_file_image">
                    <img class="img-responsive img-thumbnail" width="257" height="100">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-9 col-xs-9">
        <div class="row form-group">
            <label for="caption" class="col-form-label fw-semibold">
                {{ localize_uc('caption') }} </label>
            <input type="text" name="caption" id="caption"
                class="form-control @error('caption') is-invalid @enderror"
                placeholder="{{ localize_uc('enter_caption') }}" value="{{ old('caption') }}">
            <div class="invalid-feedback error text-danger m-2">
                @error('caption')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-3">
        <div class="row form-group">
            <label for="reference" class="col-form-label fw-semibold">
                {{ localize_uc('reference') }} </label>
            <input type="text" name="reference" id="reference"
                class="form-control @error('reference') is-invalid @enderror"
                placeholder="{{ localize_uc('enter_reference') }}" value="{{ old('reference') }}">
            <div class="invalid-feedback error text-danger m-2">
                @error('reference')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
</div>
