$(document).ready(function() {
    var tax_url = $('#tax_url').val();
    var csrf = $('meta[name="csrf-token"]').attr('content');
    $('#default_sale_tax').select2({
        ajax: {
            url: tax_url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: 'json',
            processResults: function(data) {
                //append none option
                data.unshift({
                    id: 0,
                    tax_name: 'None'
                });

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.tax_name,
                            id: item.id
                        }
                    })
                };
            },
            //show searching text false
            cache: true



        },
    });

});
