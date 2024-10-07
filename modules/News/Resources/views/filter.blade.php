<div id="collapseFilter" class="collapse bg-white mb-2">
    <form action="javascript:void(0);" id="data-table-filter" data-filter-table="#news-table">
        <div class="row fw-bold text-capitalize">
            <div class="col-xl-2 col-md-6 col-12">
                <label>{{ localize('from_date') }}</label>
                <input type="text" name="from_date" id="from_date" class="form-control date_picker"
                    placeholder="{{ localize('from_date') }}" autocomplete="off" />
            </div>
            <div class="col-xl-2 col-md-6 col-12">
                <label>{{ localize('to_date') }}</label>
                <input type="text" name="to_date" id="to_date" class="form-control date_picker"
                    placeholder="{{ localize('to_date') }}" autocomplete="off" />
            </div>
            <div class="col-xl-2 col-md-6 col-12">
                <label>{{ localize('category') }}:</label>
                <select name="other_page" id="other_page" class="form-control select-basic-single"
                    data-placeholder="{{ localize_uc('select_category') }}" data-allow-clear="true" >
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <label> Custom url :</label>
                <input type="text" name="title" class="form-control" />
            </div>

            <div class="col-xl-2 col-md-2 align-self-end">
                <button type="submit" class="btn btn-success">{{ localize('find') }}</button>
                <button type="reset" class="btn btn-danger">{{ localize('reset') }}</button>
            </div>
        </div>
    </form>
</div>
