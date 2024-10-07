
'use strict';
function deleteRole(id) {
    var role_delete_url = $('#deleteRole' + id).data('role_delete_url');
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
                url: role_delete_url,
                type: 'POST',
                data: {
                    id: id,
                    _token: csrf,
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message);
                        $('#role-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
}
