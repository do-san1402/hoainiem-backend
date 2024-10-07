$('#addPermissionForm').submit(function (e) {
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
                $('#permission-table').DataTable().ajax.reload();
                $('#addPermission').modal('hide');
                $('#addPermissionForm').trigger('reset');
            }
        },
        error: function (data) {
            toastr.error('Error', 'Error');
        }
    });
});

'use strict';
function deletePermission(id) {
    var permission_delete_url = $('#deletePermission' + id).data('permission_delete_url');
    var csrf = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: permission_delete_url,
                type: 'POST',
                data: {
                    id: id,
                    _token: csrf,
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message);
                        $('#permission-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
}
