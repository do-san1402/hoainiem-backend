$(document).ready(function() {
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();

        $('#current_password_error').text('');
        $('#new_password_error').text('');
        $('#password_confirmation_error').text('');

        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status != false) {
                    $('#changePasswordForm').trigger('reset');
                    $('#changePasswordModal').modal('hide');
                    toastr.success(data.message);
                }else{
                    $('#current_password_error').html(data.message);
                    $('#current_password').focus();
                }
                
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                if (errors.password) {
                    $('#new_password_error').html(errors.password[0]);
                    $('#new_password').focus();
                }
            }
        });
    });
});