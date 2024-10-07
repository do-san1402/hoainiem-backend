<!-- Modal -->
<div class="modal fade" id="addLanguageString" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">localize('Language String Add')</h5>
            </div>
            <form id="leadForm" action="{{ route('setting.localize.storelanstring') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 text-start">
                        <label for="string_name" class="form-label">localize('String Name')</label>
                        <input type="text" class="form-control" name="key" id="string_name"
                            placeholder="localize('String Name')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button type="submit" id="create_submit" class="btn btn-primary">localize('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
