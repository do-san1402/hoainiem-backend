$("#purchase_setting").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    var method = form.attr("method");
    var data = form.serialize();

    $.ajax({
        url: url,
        method: method,
        data: data,
        success: function (data) {
            toastr.success(data.message);
        },
    });
});


$(document).ready(function () {
    let onValue = $('#purchase_order').prop('checked');
    if (onValue == true) {
        $('#purchase_status_div').removeClass('d-none');
    } else {
        $('#purchase_status_div').addClass('d-none');
    }
});

$('#purchase_order').change(function () {
    let onValue = $('#purchase_order').prop('checked');
    $("#purchase_status").prop('checked', false);
    
    if (onValue == true) {
        $('#purchase_status_div').removeClass('d-none');
        $('.purchase_status_toggle .toggle').addClass('off');
        $('.purchase_status_toggle .toggle').addClass('btn-danger');
        $('.purchase_status_toggle .toggle').removeClass('btn-success');
    } else {
        $('#purchase_status_div').addClass('d-none');
        $('.purchase_status_toggle .toggle').removeClass('off');
        $('.purchase_status_toggle .toggle').removeClass('btn-danger');
        $('.purchase_status_toggle .toggle').addClass('btn-success');
    }
});