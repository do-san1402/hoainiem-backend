$('#product_expiry').change(function(){
    let onValue = $('#product_expiry').prop('checked')
    if(onValue == true){
        $('#on_product_expiry_main_div').removeAttr('hidden');
        $('#on_product_expiry').attr('required', true);

    } else {
        $('#on_product_expiry_main_div').attr('hidden', true);
        $('#on_product_expiry').removeAttr('required');
    }
});

$('#on_product_expiry').change(function(){
    if($(this).val() == 2){
        $('#n_days').removeAttr('hidden');
        $('#n_days').attr('required', true);

    } else {
        $('#n_days').attr('hidden', true);
        $('#n_days').removeAttr('required');
    }
});

$('#category').change(function(){
    var checked =  $('#category').prop('checked');
    if (checked) {
        $('#sub_category').show();
    }else{
        $('#sub_category').hide();
    }
});


$("#product_setting").submit(function (e) {
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
