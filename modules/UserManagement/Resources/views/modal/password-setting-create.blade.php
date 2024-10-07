<!-- Modal -->
<div class="modal fade" id="create-password-setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    New Password Setting
                </h5>
            </div>
            <form id="leadForm" action="{{ route('password-settings.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'min_length', 'type' => 'number'])
                        @input(['input_name' => 'max_lifetime', 'type' => 'number'])
                        @input(['input_name' => 'password_complexcity', 'type' => 'number'])
                        @input(['input_name' => 'password_history', 'type' => 'number'])
                        @input(['input_name' => 'lock_out_duration', 'type' => 'number'])
                        @input(['input_name' => 'session_idle_logout_time', 'type' => 'number'])
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
