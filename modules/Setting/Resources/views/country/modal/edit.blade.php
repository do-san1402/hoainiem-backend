<!-- Modal -->
<div class="modal fade" id="update-country-{{ $country->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    Edit Country
                </h5>
            </div>
            <form id="leadForm" action="{{ route('countries.update', $country->uuid) }}" method="POST"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'country_name', 'value' => $country->country_name])
                        @input(['input_name' => 'country_code', 'value' => $country->country_code])

                        @radio(['input_name' => 'is_active', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => $country->is_active])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button type="submit" class="btn btn-primary" id="update_submit">{{ localize('update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
