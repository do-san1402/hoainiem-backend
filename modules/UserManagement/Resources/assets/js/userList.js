$('#userForm').submit(function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var data = new FormData(this);
    $.ajax({
        url: url,
        type: method,
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.status == 'success') {
                toastr.success(data.message);
                $('#user-table').DataTable().ajax.reload();
                $('#addUser').modal('hide');
                $('#userForm').trigger('reset');
            }else{
                if (data.errors.full_name) {
                    $('.error_full_name').html(data.errors.full_name[0]);
                    $('#full_name').focus();
                }
                if (data.errors.email) {
                    $('.error_email').html(data.errors.email[0]);
                    $('#email').focus();
                }
                if (data.errors.contact_no) {
                    $('.error_contact_no').html(data.errors.contact_no[0]);
                    $('#contact_no').focus();
                }
                if (data.errors.password) {
                    $('.error_password').html(data.errors.password[0]);
                    $('#password').focus();
                }
                if (data.errors.role_id) {
                    $('.error_role_id').html(data.errors.role_id[0]);
                    $('#role_id').focus();
                }
                if (data.errors.profile_image) {
                    $('.error_profile_image').html(data.errors.profile_image[0]);
                    $('#profile_image').focus();
                }
            }
        },
        error: function (data) {
            toastr.error('Error', 'Something went wrong!');
        }
    });
});


"user strict";
function detailsView(id) {
    var url = $('#detailsView-'+id).data('url');
    var csrf = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            id: id,
            _token: csrf,
        },
        success: function (data) {
            if (data){
                $('#editUserData').html('');
                $('#editUserData').html(data);
                $('#editUser').modal('show');
            }
        },
        error: function (data) {
            toastr.error('Error', 'Error');
        }
    });
}


'use strict';
function deleteUser(id) {
    var user_delete_url = $('#deleteUser' + id).data('user_delete_url');
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
                url: user_delete_url,
                type: 'POST',
                data: {
                    id: id,
                    _token: csrf,
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message);
                        $('#user-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
}


