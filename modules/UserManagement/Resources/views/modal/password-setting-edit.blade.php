<!-- Modal -->
<div class="modal fade" id="edit-setting-password-{{ $passwordSetting->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    Edit Password Setting
                </h5>
            </div>
            <form id="leadForm" action="{{ route('password-settings.update', $passwordSetting->uuid) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'min_length', 'type' => 'number', 'value' => $passwordSetting->min_length])
                        @input(['input_name' => 'max_lifetime', 'type' => 'number', 'value' => $passwordSetting->max_lifetime])
                        @input(['input_name' => 'password_complexcity', 'type' => 'number', 'value' => $passwordSetting->password_complexcity])
                        @input(['input_name' => 'password_history', 'type' => 'number', 'value' => $passwordSetting->password_history])
                        @input(['input_name' => 'lock_out_duration', 'type' => 'number', 'value' => $passwordSetting->lock_out_duration])
                        @input(['input_name' => 'session_idle_logout_time', 'type' => 'number', 'value' => $passwordSetting->session_idle_logout_time])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-primary submit_button" id="create_submit">{{ localize('update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
