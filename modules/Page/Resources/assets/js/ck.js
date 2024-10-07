
var image_up_route = $('#image_up').val();

CKEDITOR.replace( 'details_news', {
    filebrowserUploadUrl: image_up_route,
    filebrowserUploadMethod: 'form',
});


"use strict";
$(document).ready(function () {

    $('#slug').hide();
    $(".page_slug a").on('click',function(){
        $('#slug').toggle('show');
    });

    // For Meta Keyword
    $('#tags').tagsinput();


    // Ajax data submit for normal FORM
    $("#pageDetailsNonModalForm").submit(function (e) {
        e.preventDefault();

        // Update the textarea with the editor's content
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        // return false;

        var url = $("#pageDetailsNonModalForm").attr("action");
        var csrf = $('meta[name="csrf-token"]').attr("content");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        });
        var formData = new FormData($("#pageDetailsNonModalForm")[0]);
        // Send an Ajax request to the server
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.error == false) {

                    // Clear the CKEditor content on successful submission
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].setData('');
                    }

                    // Clear the tags input field
                    $('#tags').tagsinput('removeAll');

                    $("#pageDetailsNonModalForm").trigger("reset");
                    toastr.success(data.msg, "Success", {
                        timeOut: 5000,
                    });
                } else {
                    toastr.error(data.msg, "Error", {
                        timeOut: 5000,
                    });
                }
            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (field_name, error) {
                    toastr.error(error, "Error:" + field_name, {
                        timeOut: 5000,
                    });

                    // Clear the CKEditor content on successful submission
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].setData('');
                    }

                    // Clear the tags input field
                    $('#tags').tagsinput('removeAll');

                    $("#pageDetailsNonModalForm").trigger("reset");
                });
            },
        });
    });

    // Ajax data submit for normal FORM
    $("#pageDetailsNonModalUpdateForm").submit(function (e) {
        e.preventDefault();

        // Update the textarea with the editor's content
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        // return false;

        var url = $("#pageDetailsNonModalUpdateForm").attr("action");
        var csrf = $('meta[name="csrf-token"]').attr("content");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        });
        var formData = new FormData($("#pageDetailsNonModalUpdateForm")[0]);
        // Send an Ajax request to the server
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.error == false) {

                    toastr.success(data.msg, "Success", {
                        timeOut: 5000,
                    });
                } else {
                    toastr.error(data.msg, "Error", {
                        timeOut: 5000,
                    });
                }
            },
            error: function (response) {
                let data = response.responseJSON;

                if(data.message){
                    toastr.error(data.message, data.title);
                }

                $.each(data.errors, function (field_name, error) {
                    toastr.error(error, "Error:" + field_name, {
                        timeOut: 5000,
                    });
                });
            },
        });
    });

});
