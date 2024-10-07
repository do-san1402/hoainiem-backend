("use strict");

/**
 * callback function
 */
var showCallBackData = function (response) {
    let data = response.data;
    $("#space_credential_model").modal("hide");
    let model_title = $("#space_credential_model").attr("data-model-title");
    $("#space_credential_model_modal-title").html(model_title);

    $(".dataTable").DataTable().ajax.reload();
};

$(document).ready(function () {
    $(document).on("click", "#add-new-space-credential", function () {
        removeFormValidation(
            $("#spaceCredentialForm"),
            new FormData(document.querySelector("#spaceCredentialForm")),
            true
        );
        $("#space_credential_model").modal("show");

        let model_title = $("#space_credential_model").attr("data-model-title");
        $("#space_credential_model_modal-title").html(model_title);

        $("#submit_button").html($("#submit_button").attr("data-insert"));
        $("#spaceCredentialForm").find('input[name="_method"]').remove();
        $("#spaceCredentialForm").attr(
            "action",
            $("#spaceCredentialForm").attr("data-insert")
        );
    });

    $(document).on("click", ".edit-space-credential", function () {
        let route = $(this).attr("data-route");
        let action = $(this).attr("data-action");
        let model_title = $("#space_credential_model").attr(
            "data-update-model-title"
        );

        $("#space_credential_model_modal-title").html(model_title);


        if (!$("#spaceCredentialForm").find('input[name="_method"]').length) {
            $("#spaceCredentialForm").prepend(
                '<input type="hidden" name="_method" value="patch" />'
            );
        }
        $("#submit_button").html($("#submit_button").attr("data-update"));

        // set form data by route
        setFormValue(
            $(this).attr("data-route"),
            $("#spaceCredentialForm"),
            new FormData(document.querySelector("#spaceCredentialForm"))
        );

        $("#spaceCredentialForm").attr("action", action);
        $("#space_credential_model").modal("show");
    });
});
