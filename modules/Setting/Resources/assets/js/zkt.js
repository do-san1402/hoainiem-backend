var table = $('#zkt-table');

function addZkt() {

    var zkt_setup_url = $("#zkt_setup_add").val();
    var lang_add_credentials = $("#lang_add_credentials").val();
    var zkt_setup_store = $("#zkt_setup_store").val();

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: zkt_setup_url,
        success: function(data) {
            $('.modal-title').text(lang_add_credentials);
            $('#zktForm').attr('action', zkt_setup_store);

            $('.modal-body').html(data);

            $('#machine_status').select2();

            $('#zktModal').modal('show');
        }
    });
}

$(document).ready(function() {
    $('#zktForm').submit(function(e) {
        e.preventDefault();

        var url = $('#zktForm').attr('action');
        var csrf = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf,
            },
        });

        var formData = new FormData($('#zktForm')[0]);

        // Send an Ajax request to the server
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                $('#zktForm').trigger('reset');
                $('#zktModal').modal('hide');


                table.DataTable().ajax.reload();

                if (data.error == false) {
                    toastr.success(data.msg, 'Success', {
                        timeOut: 5000
                    });
                } else {
                    toastr.error(data.msg, 'Error', {
                        timeOut: 5000
                    });

                }
            },

            error: function(data) {
                $.each(data.responseJSON.errors, function(field_name, error) {
                    toastr.error(error, 'Error:' + field_name, {
                        timeOut: 5000
                    });
                    $('#zktForm').trigger('reset');
                })
            }
        });
    });
});


function editZkt(id) {

    var lang_edit_credentials =$("#lang_edit_credentials").val();

    var url =$("#zkt_setup_edit").val();
    url = url.replace(':id', id);
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: url,
        success: function(data) {
            var up_url = $("#zkt_setup_update").val();
            f_up_url = up_url.replace(':id', id);

            
            $('.modal-title').text(lang_edit_credentials);
            $('#zktForm').attr('action', f_up_url);
            $('.modal-body').html(data);

            $('#machine_status').select2();

            $('#zktModal').modal('show');
        }
    });
}