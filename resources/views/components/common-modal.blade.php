<!-- Change Password Modal -->
<div class="modal fade" id="{{ isset($modalId) ? $modalId : "common-modal" }}"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" data-model-title="{{ isset($modalTitle) ? $modalTitle : null }}" data-update-model-title="{{ isset($modelUpdateTitle) ? $modelUpdateTitle : null }}">
    <div class="modal-dialog {{ isset($modalDialog) ? $modalDialog : null }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ isset($modalId) ? $modalId : "common-modal" }}_modal-title">{{ isset($modalTitle) ? $modalTitle : null }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
