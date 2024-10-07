
    var table_id = $('#get_data_table_id').val();
    var table = $('#'+table_id);

    $(document).ready(function() {
        "use strict";

        $(document).on("click", ".delete-confirm-data-table", function () {
            let url = $(this).data("route");
            let csrf = $(this).data("csrf");
            Swal.fire({
                title: get_phrases("Are you sure?"),
                text: get_phrases("You want to Delete Data"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url,
                        data: {
                            _token: csrf,
                            _method: "DELETE",
                        },
                        success: function (data) {
                            table.DataTable().ajax.reload();
                            Swal.fire("Deleted!", "Your data has been deleted.", "success");
                        },
                        error: function(response){
                            let data = response.responseJSON;
                            if(data){
                                toastr.error(data.message, data.title);
                            }
                        }
                    });
                }
            });
        });

        $("#projectDetailsForm").submit(function (e) {
            e.preventDefault();

            var url = $("#projectDetailsForm").attr("action");
            var csrf = $('meta[name="csrf-token"]').attr("content");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
            });
            var formData = new FormData($("#projectDetailsForm")[0]);
            // Send an Ajax request to the server
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    table.DataTable().ajax.reload();
                    $("#projectDetailsForm").trigger("reset");
                    $("#projectDetailsModal").modal("hide");
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
                error: function(response){
                    let data = response.responseJSON;
                    if(data){
                        toastr.error(data.message, data.title);
                    }
                    $.each(data.errors, function (field_name, error) {
                        toastr.error(error, "Error:" + field_name, {
                            timeOut: 5000,
                        });
                        $("#projectDetailsForm").trigger("reset");
                    });
                }
            });
        });

        // Ajax data submit for normal FORM
        $("#projectDetailsNonModalForm").submit(function (e) {
            e.preventDefault();

            var url = $("#projectDetailsNonModalForm").attr("action");
            var csrf = $('meta[name="csrf-token"]').attr("content");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
            });
            var formData = new FormData($("#projectDetailsNonModalForm")[0]);
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
