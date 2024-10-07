var count = 1;
var limits = 500;

("use strict");
function addTaxSettingField(divName) {

    if (count == 1) {
        count = $("#addTaxSetting tr").length + 1;
    } else {
        count++;
    }

    $("#addTaxSetting").data("count", count);

    if (count == limits) {
        alert("You have reached the limit of adding " + count + " inputs");
    } else {
        var newdiv = document.createElement("tr");
        newdiv.innerHTML =

            '<td class="text-start">'

            + '<input required type="text"  name="tax_name[]" id="tax_name_' + count + '"  required class="form-control text-start" placeholder="Tax Name" />'

             + "</td>" + '<td class="text-end">'

             + '<input required type="text" name="tax_number[]" id="tax_number_' + count + '"  required class="form-control text-end" placeholder="Tax Number" />'

             + "</td>" + '<td class="text-end">'

             + '<input required type="text" name="tax_percentage[]" id="tax_percentage_' + count + '"  required class="form-control text-end" placeholder="Tax Percentage" />'

             + "</td>" + '<td>'

             + '<button class="btn btn-danger text-end" type="button" onclick="deleteRow(this)"><i class="fa fa-close"></i></button>'

             + '</td>';

             //add tax number

             document.getElementById(divName).appendChild(newdiv);
             generateTaxNumber(count);
    }
}


//Delete row
("use strict");
function deleteRow(e) {

    var t = $("#addTaxSetting > tr").length;

    if (1 == t) alert("There only one row you can't delete.");
    else {
        var a = e.parentNode.parentNode;
        a.parentNode.removeChild(a);
    }
}


//submit form use ajax
("use strict");
$("#tax_store").submit(function (e) {
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
        var table = $('#tax-group-data-table');
        table.DataTable().ajax.reload();
});


//generate 10 digit tax number
("use strict");
function generateTenDigitNumber() {
    var tax_number = Math.floor(1000000000 + Math.random() * 9000000000);
    return tax_number;
}

//check tax name is exist or not
("use strict");
function checkTaxName(taxNumber) {
    //all old tax number
    var array = [];
    $("input[name='tax_number[]']").each(function () {
        array.push($(this).val());
    });

    if (array.includes(taxNumber)) {
        return  generateTenDigitNumber();
    }

    return taxNumber;
}


("use strict");
function addGroupTax(){
    $("#saveGroupTax")[0].reset();
    $("#tax_setting_id").empty();
    $("#addGroupTaxModal").modal("show");

}

$(document).ready(function() {
    var tax_url = $('#getTaxSettingUrl').val();
    var csrf = $('meta[name="csrf-token"]').attr('content');
    $('#tax_setting_id').select2({
        placeholder: "Select Tax",
        allowClear: true,
        ajax: {
            url: tax_url,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: 'json',
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        console.log(item);
                        return {
                            text: item.tax_name + ' (' + item.tax_percentage + '%)\n(' + item.tax_number + ')',
                            id: item.id
                        }
                    })
                };
            },
        },
    });

});


//submit form use ajax
("use strict");
$("#saveGroupTax").submit(function (e) {
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
            $("#addGroupTaxModal").modal("hide");
            $("#tax_setting_id").empty();
            $("#saveGroupTax")[0].reset();
            $('#tax-group-data-table').DataTable().ajax.reload();
        },
    });
});


//editTaxGroup
("use strict");
function editTaxGroup(id){
    $("#saveGroupTax")[0].reset();
    $("#addGroupTaxModal").modal("show");
    var url = $("#editTaxGroup"+id).data("tax_group_edit_url");
    var csrf = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: url,
        method: "POST",
        data: {
            id: id,
            _token: csrf
        },
        success: function (data) {
            $("#tax_setting_id").empty();
            data.tax_group.forEach(function (item) {
                var option = new Option(item.tax_name, item.id, true, true);
                $("#tax_setting_id").append(option).trigger('change');
            });
            $("#tax_group_id").val(data.id);
            $("#tax_group_name").val(data.tax_name);
        },
    });
}

//deleteTaxGroup
("use strict");
function deleteTaxGroup(id){
    //get tax group
    var url = $("#deleteTaxGroup"+id).data("tax_group_delete_url");
    var csrf = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: url,
        method: "POST",
        data: {
            id: id,
            _token: csrf
        },
        success: function (data) {
            toastr.success(data.message);
            $('#tax-group-data-table').DataTable().ajax.reload();
        },
    });
}









