var image_up_route = $("#image_up").val();

CKEDITOR.replace("details_news", {
    filebrowserUploadUrl: image_up_route,
    filebrowserUploadMethod: "form",
});

/**
 * create callback function
 */
var showCallBackData = function (response) {
    let data = response.data;

    setTimeout(() => {
        $("#photo-library-preview").html("");
        $("#latest_confirmed").prop("checked", true);
        $("#status_confirmed").prop("checked", true);

        $("#report_modal").modal("hide");
    }, 3000);
};

/**
 * Report Create callback function
 */
var showCallBackReportData = function (response) {
    let data = response.data;
    if (data) {
        $("#reporter_id").append(new Option(data.name, data.id));
    }

    $("#report_modal").modal("hide");
};

/**
 * Report Update callback function
 */
var showCallBackUpdateData = function (response) {
    let data = response.data;
    let redirectUrl = $("#newsDetailsForm").attr("data-redirect-url");
    if (redirectUrl) {
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 3000);
    }

    $("#photo-library-preview").html("");
};

("use strict");
$(document).ready(function () {
    $("#slug").hide();
    $(".page_slug a").on("click", function () {
        $("#slug").toggle("show");
    });

    $("#post_tag").tagsinput();
    $("#meta_keyword").tagsinput();
});
