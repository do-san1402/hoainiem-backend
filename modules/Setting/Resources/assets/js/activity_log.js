function selectAll(){
    if ($('#check_all').is(':checked', true)) {
        $(".checkbox").prop('checked', true);
    } else {
        $(".checkbox").prop('checked', false);
    }
}
function singleProductSelect(){
    if ($('.checkbox:checked').length == $('.checkbox').length) {
        $('#check_all').prop('checked', true);
    } else {
        $('#check_all').prop('checked', false);
    }
}
$(document).ready(function () {

    $('.delete-all').on('click', function (e) {
        var url = $('input[name="delete_activity_log_url"]').val();
        var csrf_token = $('[name="csrf-token"]').attr('content');

        var idsArr = [];
        $(".checkbox:checked").each(function () {
            idsArr.push($(this).attr('data-id'));
        });

        if (idsArr.length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please Select Log',
            })
            return false;
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete the selected Logs?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var strIds = idsArr.join(",");
                    $.ajax({
                        type: 'DELETE',
                        dataType: 'json',
                        url: url,
                        data: {
                            ids: strIds,
                            _token: csrf_token,
                        },
                        success: function (data) {
                            if (data['status'] == true) {
                                $(".checkbox:checked").each(function () {
                                    $(this).parents("tr").remove();
                                });

                                Swal.fire(
                                    'Deleted!',
                                    data['message'],
                                    'success'
                                )

                                var table = $('#activity-log-table');
                                table.DataTable().ajax.reload();

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went Wrong..!!',
                                })
                            }
                        },
                        error: function (response) {
                            let data = response.responseJSON;
                            if(data.message){
                                toastr.error(data.message, data.title);
                            }
                        }
                    });

                }
            })

        }
    });
});

// custom filter
$(document).ready(function() {
    var user_name_url = $('#user_name').data('url');
    var csrf = $('meta[name="csrf-token"]').attr('content');

    $('#filter').click(function() {
        var user_name = $('#user_name').val();
        var log_date = $('#log_date').val();

        var table = $('#activity-log-table');
        table.on('preXhr.dt', function(e, settings, data) {
            data.user_name = user_name;
            data.log_date = log_date;

        });
        table.DataTable().ajax.reload();
    });

    $('#search-reset').click(function() {
        $('#user_name').val('').trigger('change');
        $('#log_date').val('');


        var table = $('#activity-log-table');
        table.on('preXhr.dt', function(e, settings, data) {
            $("#user_name").select2({
                placeholder: "User Name",
                ajax: {
                    url: user_name_url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    dataType: 'json',
                },
            });
            data.user_name = '';
            data.log_date = '';
        });
        table.DataTable().ajax.reload();
    });


    $('#user_name').select2({
        ajax: {
            url: user_name_url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: 'json',
        },
    });

})
