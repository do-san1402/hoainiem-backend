<div class="row ps-4 pe-4">

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="category_type"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('select_type') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="category_type" id="category_type" class="form-control select-basic-single" required>
                    <option value="">--{{ localize('select') }}--</option>
                    <option value="1">{{ localize('category') }}</option>
                    <option value="2">{{ localize('topic') }}</option>
                </select>

            </div>

            @if ($errors->has('category_type'))
                <div class="error text-danger m-2">{{ $errors->first('category_type') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="category_name"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('category_name') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <input type="text" class="form-control" id="category_name" name="category_name"
                    placeholder="{{ localize('category_name') }}" value="{{ old('category_name') }}" required>
            </div>

            @if ($errors->has('category_name'))
                <div class="error text-danger m-2">{{ $errors->first('category_name') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="category_topic"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('category_topic') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="category_topic[]" id="category_topic" class="form-control select-basic-single" multiple="multiple">
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->category_name }}
                        </option>
                    @endforeach
                </select>

            </div>

            @if ($errors->has('category_topic'))
                <div class="error text-danger m-2">{{ $errors->first('category_topic') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="slug"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('slug') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <input type="text" class="form-control" id="slug" name="slug"
                    placeholder="{{ localize('slug') }}" value="{{ old('slug') }}" required>
            </div>

            @if ($errors->has('slug'))
                <div class="error text-danger m-2">{{ $errors->first('slug') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="description"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('description') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <textarea  class="form-control" id="description" name="description"
                    placeholder="{{ localize('description') }}" rows ="5"></textarea>
            </div>

            @if ($errors->has('description'))
                <div class="error text-danger m-2">{{ $errors->first('description') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="category_image"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('category_image') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <input type="file" class="form-control" id="category_image" name="category_image"
                 class="form-control" aria-describedby="categoryNote" accept="image/*" autocomplete="off">

                <small id="categoryNote" class="form-text text-black">N.B: {{ localize('1350*350 & max size 1MB') }}</small>

                <small id="fileHelp" class="text-muted mt-2"><img src="{{ asset('backend/assets/dist/img/signature_signature.jpg') }}" 
                id="output" class="img-thumbnail mt-2" width="300" style="height: 120px !important;">

            </div>

        </div>
    </div>

</div>
