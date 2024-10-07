$('.edit-currency').click(function(e) {
    e.preventDefault();
    var currency_id = $(this).val();
    $.get('currencies/' + currency_id + '/edit', function(response) {
        $('#currency-id').val(currency_id);
        $('#currency_title').val(response.data.title);
        $('#symbol').val(response.data.symbol);
        $('#countries').val(response.data.country_id).change();
        response.data.status == 1 ? $('#currency_status_active').attr("checked", "checked")
            .change() : $('#currency_status_inactive').attr("checked", "checked").change();
        $('#addCurrencyModal').modal('show');
    })

    $("#currency-submit").click(function(e) {
        e.preventDefault();
        var currency_id = $('#currency-id').val();
        var currencyData = $('#currency-form').serializeArray();
        var currencyRoute = "{{ route('currencies.update', ':id') }}";
        currencyRoute = currencyRoute.replace(':id', currency_id);
        ajaxSubmit(currencyRoute, 'PUT', currencyData);
        $('#addCurrencyModal').modal('hide');
        location.reload();
    });
});