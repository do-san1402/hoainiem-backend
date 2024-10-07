<div class="row">
    <div class="col-md-6">
        <div class="row form-group">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <label for="short_head" class="col-form-label fw-semibold">{{ localize_uc('category') }} <span
                        class="text-danger">*</span>
                </label>
                <select name="other_page" id="other_page" class="form-control select-basic-single"
                    data-placeholder="{{ localize_uc('select_category') }}" data-allow-clear="true" required>
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(old('other_page', $photoPost->category ?? null) == $category->slug)>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback error text-danger m-2">
                    @error('short_head')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row form-group">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <label for="short_head" class="col-form-label fw-semibold">{{ localize_uc('short_head') }}
                </label>
                <input type="text" name="short_head" id="short_head"
                    class="form-control @error('short_head') is-invalid @enderror"
                    placeholder="{{ localize_uc('enter_short_head') }}"
                    value="{{ old('short_head', $photoPost->stitle ?? null) }}">
                <div class="invalid-feedback error text-danger m-2">
                    @error('short_head')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row form-group">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <label for="head_line" class="col-form-label fw-semibold">{{ localize_uc('head_line') }}
                    <span class="text-danger">*</span> </label>
                <input type="text" name="head_line" id="head_line"
                    class="form-control @error('head_line') is-invalid @enderror"
                    placeholder="{{ localize_uc('enter_head_line') }}"
                    value="{{ old('head_line', $photoPost->title ?? null) }}" required>
                <div class="invalid-feedback error text-danger m-2">
                    @error('head_line')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group mt-3">
    <button type="button" class="btn btn-sm btn-success" id="add-photo-gallery-button">
        {{ localize('add_photo_gallery') }}
        <i class="fas fa-plus"></i>
    </button>
</div>
<div id="add_gallery" data-div_id="{{ !empty($photoPost) && !empty($photoPost->photoPostDetails) ? count($photoPost->photoPostDetails) + 1 : 1 }}">
    @if (!empty($photoPost))
        @foreach ($photoPost->photoPostDetails as $photoPostDetail)
            @php
                $key = $loop->iteration;
            @endphp
            <div class="row gallery_image_div" id="{{ $key }}">
                <div class="col-lg-3 col-md-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-600">{{ localize('image') }}</label>
                        <div class="btn-select-image">
                            <div id="photo-library-preview{{ $key }}">
                                @if ($photoPostDetail->photoLibrary)
                                    <img class="img-responsive img-thumbnail"
                                        src="{{ storage_asset_image($photoPostDetail->photoLibrary->thumb_image) }}"
                                        alt="{{ $photoPostDetail->photoLibrary->title }}" height="100"
                                        width="100" />
                                @endif
                            </div>
                            <input type="hidden" name="lib_file_selected[]" id="photo_library_name{{ $key }}"
                                value="{{ $photoPostDetail->image }}">
                            <a href="{{ route('photo-library.view', ['div_id' => $key]) }}"
                                class="photo-library-page text-success">
                                <i class="fa fa-cloud-upload-alt"></i> [ jpg,png,jpeg,gif]
                            </a>
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <label for="image_alt"
                                class="col-form-label fw-semibold">{{ localize_uc('image_alt') }}</label>
                            <input type="text" id="image_alt{{ $key }}" name="image_alt[]"
                                class="form-control" placeholder="{{ localize_uc('enter_image_alt') }}"
                                value="{{ $photoPostDetail->title }}">
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <label for="image_title"
                                class="col-form-label fw-semibold">{{ localize_uc('image_title') }}</label>
                            <input type="text" id="image_title{{ $key }}" name="image_title[]"
                                class="form-control" placeholder="{{ localize_uc('enter_image_title') }}"
                                value="{{ $photoPostDetail->photo_reference }}">
                            <div class="invalid-feedback error text-danger m-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-6">
                    <button type="button" class="btn btn-sm btn-danger mt-4 delete-photo-gallery-button">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
    @endif
</div>
<div class="col-md-12 mt-3">
    <div class="row form-group">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <label for="meta_description"
                class="col-form-label fw-semibold">{{ localize_uc('meta_description') }}</label>
            <textarea name="meta_description" id="meta_description"
                class="form-control @error('meta_description') is-invalid @enderror"
                placeholder="{{ localize_uc('enter_meta_description') }}" rows ="3">{{ old('reference', $photoPost->meta_description ?? null) }}</textarea>
            <div class="invalid-feedback error text-danger m-2">
                @error('meta_description')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
</div>
