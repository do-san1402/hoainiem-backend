function addArchiveDetails() {

    var url = $("#archive_create").val();

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: url,
        success: function(data) {
            var f_up_url = $("#archive_store").val();

            var lang_add_archive = $("#lang_add_archive").val();

            $('.modal-title').text(lang_add_archive);
            $('#projectDetailsForm').attr('action', f_up_url);
            $('.modal-body').html(data);

            $('#category_id').select2();

            $('#projectDetailsModal').modal('show');
        }
    });
}

function archiveCreate(category_id , available_for_archive) {

    var id = category_id+'~'+available_for_archive;
    $('.a').attr('id', id);

    $('#myModalToArchiveNews').modal('show');
}

var table_id = $('#get_data_table_id').val();
var table = $('#'+table_id);

$(document).ready(function() {
    "use strict";

    // Ajax data submit for normal FORM
    $("#archiveDataUpdate").submit(function (e) {
        e.preventDefault();

        var url = $("#archiveDataUpdate").attr("action");
        var csrf = $('meta[name="csrf-token"]').attr("content");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
        });
        var formData = new FormData($("#archiveDataUpdate")[0]);

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

                    table.DataTable().ajax.reload();

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
                if(data){
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

    $('#start_archive').click(function () {

        $("#processing").html("Processing....");

        var catID_Avaibale = $('.a').attr('id');
        var total_news_by_category = catID_Avaibale.split("~");
        var total_call = Math.ceil(total_news_by_category[1] / 10);
        var timerId = 0;
        var counter = 0;

        timerId = setInterval(function () {
            ++counter;

            ajaxCallToCreateArchive(catID_Avaibale);

            var percentage = Math.round(((10 * counter) * 100) / total_news_by_category[1]);
            if (percentage > 100) {
                percentage = 100;
            }

            $('.archive_process').css(
                'width', percentage + '%'
            );

            $('.archive_process').html(percentage + '%');

            if (counter === total_call) {

                $("#processing").html("Completed");
                $(".archive_status").removeClass('d-none');
                $(".archive_status").addClass('d-block');
                $(".a").addClass('disabled');
                $(".a").addClass('d-none');
                clearInterval(timerId);
            }

        }, 5000);
    });

    function ajaxCallToCreateArchive(catID_Avaibale) {

        var lang_archive_news = $('#lang_archive_news').val();

        var url = $('#archive_newses_by_category').val();
        url = url.replace(':cat_id_available', catID_Avaibale);

        $('#myModalLabel').html(lang_archive_news);
        $.ajax({
            url: url,
            context: document.body
        }).done(function (data) {
        });
    }

    $('#myModalToArchiveNews').on('hide.bs.modal', function () {
        table.DataTable().ajax.reload();
    });

});
