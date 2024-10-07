$('#editMenuForm').submit(function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var data = $(this).serialize();
    var csrf = $('meta[name="csrf-token"]').attr('content');
    data._token = csrf;
    $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'JSON',
        success: function (data) {
            if (data.status == 'success') {
                toastr.success(data.message);
                $('#menu-table').DataTable().ajax.reload();
                $('#editMenu').modal('hide');
                $('#editMenuForm').trigger('reset');
            }
        },
        error: function (data) {
            toastr.error('Error', 'Error');
        }
    });
});
