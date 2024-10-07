<!-- Database Import Password Check -->
<div class="modal fade" id="show-password-check-modal-{{ $key + 1 }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="forImportDatabase" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="password-check-{{ $key + 1 }}" action="{{ route('backup.password_check') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <label for="password-{{ $key + 1 }}"
                        class="form-label">{{ localize('enter_your_password') }}</label>
                    <input type="password" class="form-control" id="password-{{ $key + 1 }}"
                        placeholder="{{ localize('enter_password') }}">
                    <span class="text-danger" id="passwordErrorForImportDatabase{{ $key + 1 }}"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>

                    <button type="button" class="btn btn-success submit_button"
                        onclick="passwordCheck({{ $key + 1 }})">{{ localize('confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
