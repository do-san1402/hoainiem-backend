$('.select-basic-single').select2();
    $('#editUserForm').submit(function (e) {
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
                $('#editUser').modal('hide');
                $('#editUserForm').trigger('reset');
                location.reload();
            }else{

                // console.log(data);
                // return false;

                if(data.errors){

                    // if (data.errors.full_name) {
                    //     $('.error_full_name').html(data.errors.full_name[0]);
                    //     $('#full_name').focus();
                    // }
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
            }
        }
    });
});
