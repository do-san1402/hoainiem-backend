<!-- Modal -->
<div class="modal fade" id="create-country" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    New Country
                </h5>
            </div>
            <form id="leadForm" action="{{ route('countries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'country_name'])
                        @input(['input_name' => 'country_code'])
                        @radio(['input_name' => 'is_active', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => 1])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button type="reset" class="btn btn-primary" id="reset">Reset</button>
                    <button type="submit" class="btn btn-primary submit_button"
                        id="create_submit">{{ localize('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
