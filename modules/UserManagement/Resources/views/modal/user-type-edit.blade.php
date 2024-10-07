<!-- Modal -->
<div class="modal fade" id="edit-user_type-{{ $userType->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    Edit User Type
                </h5>
            </div>
            <form id="leadForm" action="{{ route('user-types.update', $userType->uuid) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'user_type_title', 'value' => $userType->user_type_title])
                        @radio(['input_name' => 'is_active', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => $userType->is_active])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-primary submit_button" id="create_submit">{{ localize('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
