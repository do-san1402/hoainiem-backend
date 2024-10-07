<div class="row ps-4 pe-4">

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="category_id"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('category') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="category_id" class="form-control" id="category_id" required="1">
                    <option>{{localize('select')}}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ htmlspecialchars($category->category_name) }}</option>
                    @endforeach
                </select>

            </div>

            @if ($errors->has('category_id'))
                <div class="error text-danger m-2">{{ $errors->first('category_id') }}</div>
            @endif
        </div>
    </div>

</div>


