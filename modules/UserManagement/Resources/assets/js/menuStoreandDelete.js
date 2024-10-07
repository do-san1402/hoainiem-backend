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
                $('#editMenuData').html('');
                $('#editMenuData').html(data);
                $('#editMenu').modal('show');
            }
        },
        error: function (data) {
            toastr.error('Error', 'Error');
        }
    });
}


'use strict';
function deleteMenu(id) {
    var menu_delete_url = $('#deleteMenu' + id).data('menu_delete_url');
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
                url: menu_delete_url,
                type: 'POST',
                data: {
                    id: id,
                    _token: csrf,
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message);
                        $('#menu-table').DataTable().ajax.reload();
                    }
                }
            });
        }
    });
}


//submit form useing ajax form id #menuForm

$('#menuForm').submit(function (e) {
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
                $('#addmenu').modal('hide');
                $('#menuForm').trigger('reset');
            }
        },
        error: function (data) {
            toastr.error('Error', 'Error');
        }
    });
});



