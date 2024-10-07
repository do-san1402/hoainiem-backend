function addReporterDetails() {

    var url = $("#reporter_create").val();

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: url,
        success: function(data) {
            var f_up_url = $("#reporter_store").val();

            var lang_add_reporter = $("#lang_add_reporter").val();

            $('.modal-title').text(lang_add_reporter);
            $('#projectDetailsForm').attr('action', f_up_url);
            $('.modal-body').html(data);

            $('#department_id').select2();
            $('#user_type').select2();
            $('#sex').select2();
            $('#country').select2();
            $('#verification_type').select2();

            $(".date_picker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
            });

            $('#projectDetailsModal').modal('show');
        }
    });
}

$(document).ready(function() {
    "use strict";

     // Function to preview image
    $(document).on('change', '#photo', function(){
        var file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function(e){
            $('#output').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });

    $(document).on("click", ".reporter-status-change", function () {
        let url = $(this).data("route");
        let csrf = $(this).data("csrf");

        Swal.fire({
            title: get_phrases("Are you sure?"),
            text: get_phrases("You want to update status"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    data: {
                        _token: csrf,
                        _method: "PUT",
                    },
                    error: function (response) {
                        let data = response.responseJSON;

                        if(data.message){
                            toastr.error(data.message, data.title);
                        }
                    },
                    success: function (data) {
                        $('#reporter-table').DataTable().ajax.reload();
                        Swal.fire("Updated!", "Status has been updated.", "success");
                    },
                });
            }
        });
    });

});


function editReporterDetails(id) {

    var url = $("#reporter_edit").val();
    url = url.replace(':reporter', id);

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: url,
        success: function(data) {
            var up_url = $("#reporter_update").val();
            f_up_url = up_url.replace(':reporter', id);

            var lang_update_reporter = $("#lang_update_reporter").val();

            $('.modal-title').text(lang_update_reporter);
            $('#projectDetailsForm').attr('action', f_up_url);
            $('.modal-body').html(data);

            $('#department_id').select2();
            $('#user_type').select2();
            $('#sex').select2();
            $('#country').select2();
            $('#verification_type').select2();

            $(".date_picker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
            });

            $('#projectDetailsModal').modal('show');
        }
    });
}







