$(document).ready(function () {
    $('#passwordEnter').on('shown.bs.modal', function () {
        $('#password1').focus();
    });
    $('#passwordEnter').on('hidden.bs.modal', function () {
        $('#password1').val('');
        $('#passwordError').text('');
    });


    // Database Factory Reset
    $('#passwordEnter .btn-success').on('click', function () {
        var password = $('#password1').val();
        if (password == '') {
            $('#passwordError').text('Please enter your password');
            return false;
        }
        $('#passwordError').text('');

        var url = $('#factory_reset').attr('action');
        var formData = $('#factory_reset').serialize();
        var method = $('#factory_reset').attr('method');
        var token = $('#factory_reset').find('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: method,
            data: {
                "_token": token,
                "password": password
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#passwordEnter').modal('hide');
                    toastr.success(response.message);
                } else {
                    $('#passwordError').text(response.message);
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#database_backup_button').on('click', function () {

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Backup Your Database",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Backup it!',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {

                
                $('#database_backup_modal').modal('show');
                var url = $('#database_backup').attr('action');
                var csrf_token = $('input[name="_token"]').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": csrf_token,
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            $('#database_backup_modal').modal('hide');


                            Swal.fire(
                                'Backup!',
                                'Your Database has been Backup.',
                                'success'
                            )

                        }
                    }
                });
            }
        })
    });
});

$(document).on('click', '.upload-field', function () {
    var file = $(this).parent().parent().parent().find('.input-file');
    file.trigger('click');
});
$(document).on('change', '.input-file', function () {
    var filename = $(this).val();
    if (filename) {
        $('.confirm_import_button').prop('disabled', false);
    }
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});

$(document).ready(function () {
    if (!$('.input-file').val()) {
        $('.confirm_import_button').prop('disabled', true);
    }
});

$('.confirm_import_button').on('click', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Import Your Database",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Import it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $('#passwordEnterForImportDatabase').modal('show');
        }
    })
});
function passwordCheckButton() {
    
    $('#passwordEnterForImportDatabase').on('shown.bs.modal', function () {
        $('#password2').focus();
    });
    $('#passwordEnterForImportDatabase').on('hidden.bs.modal', function () {
        $('#password2').val('');
        $('#passwordErrorForImportDatabase').text('');
    });

    // $('#database_import_modal').modal('show');
    var url = $('#password_check').attr('action');
    var form = $('#password_check');
    var csrf_token = $('[name="csrf-token"]').attr('content');
    var formData = new FormData(form[0]);
    formData.append('_token', csrf_token); // Append the CSRF token
    formData.append('password', $('#password2').val()); // Append the CSRF token

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        success: function (response) {
            if (response.passwordCheck == 'success') {
                $('#database_import_modal').modal('show');
                confirmImportDatabase();
            } else {
                $('#passwordErrorForImportDatabase').text(response.message);
            }
        }
    });
};


function confirmImportDatabase() {
    var url = $('#confirm_import').attr('action');
    var form = $('#confirm_import');
    
    var csrf_token = $('[name="csrf-token"]').attr('content');
    var formData = new FormData(form[0]);
    formData.append('_token', csrf_token); // Append the CSRF token
    formData.append('database_import',form[0]); // Append DatabaseFile

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        success: function (response) {
            if (response.status == 'success') {
                location.reload();
                $('#database_import_modal').modal('hide');

                Swal.fire(
                    'Import!',
                    'Your Database has been Import.',
                    'success'
                );
                toastr.success(response.message);

            } else {
                $('#database_import_modal').modal('hide');
                $('#database_import_error').text(response.message);
            }
        }
    });
};

function confirmImportButton(sl){

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to Import Your Database",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Import it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $('#show-password-check-modal-'+sl).modal('show');
        }
    })
}

function passwordCheck(sl){
    $('#show-password-check-modal-'+sl).on('shown.bs.modal', function () {
        $('#password-'+sl).focus();
    });
    $('#show-password-check-modal-'+sl).on('hidden.bs.modal', function () {
        $('#password-'+sl).val('');
        $('#passwordErrorForImportDatabase'+sl).text('');
    });

    var url = $('#password-check-'+sl).attr('action');
    var form = $('#password-check-'+sl);
    var csrf_token = $('[name="csrf-token"]').attr('content');
    var formData = new FormData(form[0]);
    formData.append('_token', csrf_token); // Append the CSRF token
    formData.append('password', $('#password-'+sl).val()); // Append the CSRF token

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        success: function (response) {
            if (response.passwordCheck == 'success') {
                $('#database_import_modal').modal('show');

                
                var url = $('#confirm-import-'+sl).attr('action');
                var form = $('#confirm-import-'+sl);
                
                var csrf_token = $('[name="csrf-token"]').attr('content');
                var formData = new FormData(form[0]);
                formData.append('_token', csrf_token); // Append the CSRF token

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                            $('#database_import_modal').modal('hide');

                            Swal.fire(
                                'Import!',
                                'Your Database has been Import.',
                                'success'
                            );
                            toastr.success(response.message);

                        } else {
                            $('#database_import_modal').modal('hide');
                            $('#database_import_error').text(response.message);
                        }
                    }
                });
            } else {
                $('#passwordErrorForImportDatabase'+sl).text(response.message);
            }
        }
    });
}

$('#factory_reset').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });