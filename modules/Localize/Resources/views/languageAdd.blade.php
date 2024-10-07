<!-- Modal -->
<div class="modal fade" id="addLanguage" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ localize('Language Add') }}</h5>
            </div>
            <form id="leadForm" action="{{ route('setting.localize.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-start">
                            <div class="row mt-3">
                                <label for="langName"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('Language Name') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">

                                    <input type="hidden" class="form-control" id="langNameText" name="langname">
                                    <select id="langName" class="select-basic-single" required>
                                        <option value="" selected disabled>--{{ localize('select_one') }}--
                                        </option>
                                        @foreach ($langList_DB as $value)
                                            <option value="{{ $value->value }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('langname'))
                                        <div class="error text-danger m-2">{{ $errors->first('langname') }}</div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('Language Code') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="langCode" readonly name="value"
                                        placeholder="{{ localize('Language Code') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button type="submit" id="create_submit" class="btn btn-primary">{{ localize('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
