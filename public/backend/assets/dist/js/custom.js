$(document).ready(function () {
    $('#basic-datatable').DataTable({
        searching: true,
    });

    $("#start_time").timepicker({
        datepicker: false,
        pickTime: true,
        useSeconds: false,
        use24hours: true,
        format: 'H:i',
        step: 15
    });


    $("#end_time").timepicker({
        datepicker: false,
        pickTime: true,
        useSeconds: false,
        use24hours: true,
        format: 'H:i',
        step: 15
    });

    var cashbookTable = $('#cashbook-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Cashbook-Report-Excel'
            }
        ]
    });
    cashbookTable.buttons().container().appendTo('.export-cashbook');

    var bankbookTable = $('#bankbook-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Bankbook-Report-Excel'
            }
        ]
    });
    bankbookTable.buttons().container().appendTo('.export-bankbook');

    var dayBookTable = $('#daybook-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Daybook-Report-Excel'
            }
        ]
    });
    dayBookTable.buttons().container().appendTo('.export-daybook');

    var generalLedgerTable = $('#general-ledger-table').DataTable({
        dom: 'lBfrtip',
        //show all data
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'General-Ledger-Report-Excel'
            }
        ]
    });
    generalLedgerTable.buttons().container().appendTo('.export-general-ledger');


    var subLedgerTable = $('#sub-ledger-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Sub-Ledger-Report-Excel'
            }
        ]
    });
    subLedgerTable.buttons().container().appendTo('.export-sub-ledger');

    var controlLedgerTable = $('#control-ledger-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Control-Ledger-Report-Excel'
            }
        ]
    });
    controlLedgerTable.buttons().container().appendTo('.export-control-ledger');

    var noteLedgerTable = $('#note-ledger-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        searching: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Note-Ledger-Report-Excel'
            }
        ]
    });
    noteLedgerTable.buttons().container().appendTo('.export-note-ledger');

    var receiptPaymentTable = $('#receipt-payment-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        bInfo: false,
        paging: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Receipt-Payment-Report-Excel'
            }
        ]
    });
    receiptPaymentTable.buttons().container().appendTo('.export-receipt-payment');

    var trailBalance = $('#trail-balance-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        bInfo: false,
        paging: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Trail-Balance-Report-Excel'
            }
        ]
    });
    trailBalance.buttons().container().appendTo('.export-trail-balance');

    var profitLoss = $('#profit-loss-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        bInfo: false,
        paging: false,

        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Profit-Loss-Report-Excel'
            }
        ],

    });
    profitLoss.buttons().container().appendTo('.export-profit-loss');

    var balanceSheet = $('#balance-sheet-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        paging: false,
        bInfo: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                title: 'Balance-Sheet-Report-Excel'
            }
        ]
    });
    balanceSheet.buttons().container().appendTo('.export-balance-sheet');

    var liabilitiesBalanceSheet = $('#liabilities-balance-sheet-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        paging: false,
        bInfo: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Liabilities Balance Sheet Excel',
                className: 'btn btn-success',
                title: 'Liabilities-Balance-Sheet-Report-Excel'
            }
        ]
    });
    liabilitiesBalanceSheet.buttons().container().appendTo('.export-liabilities-balance-sheet');

    var assetsBalanceSheet = $('#assets-balance-sheet-table').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        ordering: false,
        searching: false,
        bInfo: false,
        paging: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Assets Balance Sheet Excel',
                className: 'btn btn-success',
                title: 'assets-Balance-Sheet-Report-Excel'
            }
        ]
    });
    assetsBalanceSheet.buttons().container().appendTo('.export-assets-balance-sheet');

});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function () {
    "use strict";
    var invalidChars = ["-", "e", "+", "E"];

    $("input[type='number']").on("keypress", function (e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    });

    $("#update").delay(3000).hide(500);
    $("#fail").delay(3000).hide(500);
    $("#success").delay(3000).hide(500);
    $("#warning").delay(3000).hide(500);

    $('.search_test').SumoSelect({
        search: true,
        searchText: 'Enter here.'
    });
    $('.testselect2').SumoSelect({
        search: true,
        searchText: 'Enter here.'
    });

    $("#tax_id").change(function () {
        var taxId = $("#tax_id").val();
        getTaxValue(taxId);
    });

    $("#fee_amount").keypress(function () {
        $("#tax_amount").val('');
    });


    $("#paid_amount").on('change mouseup mousedown mouseout keyup', function () {
        var totalPayable = $("#payable_amount").val();
        var totalPaid = $("#paid_amount").val();

        var totaDue = parseFloat(totalPayable) - parseFloat(totalPaid)

        $("#due_amount").val(totaDue);
    });

});

$(document).ready(function () {

    elementLoader = {
        "show": function (elem, size = 50, legend = true) {
            var $elem = $(elem),
                oldPosition = $elem.css('position');

            $(".page-loader-wrapper", $elem).remove();
            $elem.css('position', 'relative').attr('data-oldposition', oldPosition);
            $elem.append(`<div class="page-loader-wrapper" style="position:absolute;background:#fff0df70;">
                <div class="loader" style="top:calc(50% - ${size / 2}px)"><div class="preloader" style="width:${size}px;height:${size}px">
                <div class="spinner-layer pl-green"><div class="circle-clipper left"><div class="circle"></div></div>
                <div class="circle-clipper right"><div class="circle"></div></div></div></div>
                ${legend ? '<p>Please Wait...</p></div>' : ''}</div>`);
        },

        "hide": function (elem) {
            var $elem = $(elem),
                oldPosition = $elem.attr('data-oldposition');

            oldPosition && $elem.css('position', oldPosition).removeAttr('data-oldposition');
            $(".page-loader-wrapper", $elem).remove();
        }
    }

    $(".tabs").click(function () {

        $(".tabs").removeClass("active");
        $(".tabs h6").addClass("text-muted");
        $(this).children("h6").removeClass("text-muted");
        $(this).addClass("active");

        current_fs = $(".active");

        next_fs = $(this).attr('id');
        next_fs = "#" + next_fs + "1";

        $("fieldset").removeClass("show");
        $(next_fs).addClass("show");

        current_fs.animate({}, {
            step: function () {
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'display': 'block'
                });
            }
        });
    });
});

function getTaxValue(taxid) {
    "use strict";

    var baseurl = $("#baseurl").val();
    var url = baseurl + '/tax/amount/' + taxid;


    $.ajax({
        type: 'GET',
        url: url,

        success: function (data) {

            if (data.taxDetail.is_percentage == 1) {
                var percentage = data.taxDetail.percentage;
                var fee = $("#fee_amount").val();
                var taxamount = (parseFloat(percentage) / 100) * parseFloat(fee);
                $("#tax_amount").val(taxamount);
            }
            if (data.taxDetail.is_percentage == 0) {
                var amount = data.taxDetail.amount;
                $("#tax_amount").val(amount);
            }

        }
    });
}

$(document).ready(function () {
    $("#date_picker").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        // yearRange: "-100:+0",
        showAnim: "slideDown",
    });
});

$(document).ready(function () {
    $(".date_picker").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    });
});

$(function () {
    $(".expiry_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    });
});

$(function () {
    $(".purchase_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        // yearRange: "-100:+0",
        showAnim: "slideDown",
    });
});


"use strict"; // Start of use strict
function printContent() {
    var printContents = document.getElementById('print-content').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    location.reload();
    document.body.innerHTML = originalContents;
}

function printDetails() {
    $('#print-table').find('table').addClass('fs-14');
    // $('#print-table').find('table').addClass('table-border');

    // remove pagination show when printing
    $('#print-table').find('.dataTables_paginate').addClass('d-none');
    $('#print-table').find('.dataTables_paginate').removeClass('dataTables_paginate');
    //remove Showing 0 to 0 of 0 entries
    $('#print-table').find('.dataTables_info').addClass('d-none');
    $('#print-table').find('.dataTables_info').removeClass('dataTables_info');
    //remove search box
    $('#print-table').find('.dataTables_filter').addClass('d-none');
    $('#print-table').find('.dataTables_filter').removeClass('dataTables_filter');
    //remove table length
    $('#print-table').find('.dataTables_length').addClass('d-none');
    $('#print-table').find('.dataTables_length').removeClass('dataTables_length');

    $('body').css('padding', '0px');
    //body background white
    $('body').css('background-color', 'white');


    $('table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled').css('display', 'none');


    setTimeout(function () {
        var printContents = document.getElementById('print-table').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();

        location.reload();
        document.body.innerHTML = originalContents;
    }, 500);
}

function salaryChart() {
    $('#print-table').find('.salary-chart-table').addClass('table-border');
    setTimeout(function () {
        var printContents = $('#print-table').html();
        var originalContents = $('body').html();
        $('body').html(printContents);
        window.print();

        location.reload();
        $('body').html(originalContents);
    }, 500);
}

"use strict";
function accountReportPrintDetails() {
    $('body').css('padding', '0px');
    $('body').css('background-color', 'white');
    $('#print-table').find('table').addClass('table-border fs-12');
    $('#print-table').find('table').removeClass('table-bordered', 'table-striped');
    $('#print-table').find('.border-top').addClass('border-top-black');
    $('#print-table').find('#sub-ledger-table').removeClass('dataTable');
    $('#print-table').find('#cashbook-table').removeClass('dataTable');
    $('#print-table').find('#bankbook-table').removeClass('dataTable');
    $('#print-table').find('#daybook-table').removeClass('dataTable');
    $('#print-table').find('#general-ledger-table').removeClass('dataTable');
    $('#print-table').find('#control-ledger-table').removeClass('dataTable');
    $('#print-table').find('#note-ledger-table').removeClass('dataTable');
    $('#print-table').find('#trail-balance-table').removeClass('dataTable');
    $('#print-table').find('#profit-loss-table').removeClass('dataTable');
    $('#print-table').find('.card-body').removeClass('hr-customize');
    $('#print-table').find('.table-responsive').addClass('table-print');
    //wait for 0.5 second
    setTimeout(function () {
        var printContents = document.getElementById('print-table').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function () {
            location.reload();
        }, 100);
    }, 500);
}

("use strict");
function printPage() {
    setTimeout(function () {
        var printContents = document.getElementById('viewData').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        location.reload();
        document.body.innerHTML = originalContents;
    }, 1000);
    addPageNumbers();
}


("use strict");
function addPageNumbers() {

    var printArea = document.getElementById('viewData');
    var totalPages = Math.ceil(printArea.scrollHeight / 1123);
    for (var i = 1; i <= totalPages; i++) {

        var pageNumberDiv = document.createElement("div");
        var invoiceFooterDiv = document.createElement("div");
        var pageNumber = document.createTextNode("Page " + i + " of " + totalPages);

        pageNumberDiv.classList.add("page-no");
        pageNumberDiv.style.position = "absolute";
        if (i > 1) {
            pageNumberDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 100px)";
        } else {
            pageNumberDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 60px)";
        }
        pageNumberDiv.style.height = "16px";
        pageNumberDiv.appendChild(pageNumber);
        printArea.insertBefore(pageNumberDiv, document.getElementById("print-table"));
        pageNumberDiv.style.left = "calc(50% - (" + (pageNumberDiv.offsetWidth / 2) + "px))";

        invoiceFooterDiv.classList.add("page-no");
        invoiceFooterDiv.style.position = "absolute";
        invoiceFooterDiv.style.backgroundSize = "cover";
        invoiceFooterDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 50px)";
        invoiceFooterDiv.style.height = "50px";
        invoiceFooterDiv.style.width = "100%";
        invoiceFooterDiv.style.left = "0px";

    }
}

"use strict"; // Start of use strict
function employeePrintDetails() {
    $('#print-table .print-col').removeClass('col-lg-4 col-md-4 col-12');
    $('#print-table .footer-bg').removeClass('d-none');
    $('#print-table .print-col').addClass('col-middle-6 bg-white');
    $('#print-table .print-col .card').addClass('shadow-none');
    $('#print-table .card-header').addClass('pb-0');
    $('#print-table .employee-print-header, #print-table .employee-print-body').addClass('bg-white');
    $('#print-table .employee-show-header, #print-table .print-col .card').addClass('rounded-0');
    $('#print-table .print-row').addClass('fs-12 bg-white');
    $('#print-table .employee-show-header').addClass('pb-2');
    $('#print-table .employee-print-body h6').addClass('fs-13');
    $('#print-table .employee-print-body h6').removeClass('fs-14');
    $('#print-table .avatar-preview #imagePreview').addClass('border-0');

    $('.fixed .sidebar-mini ').addClass('bg-white');

    //wait for 0.5 second
    setTimeout(function () {
        var printContents = document.getElementById('print-table').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        // return
        window.print();
        location.reload();
        document.body.innerHTML = originalContents;
    }, 500);

}

//download pdf
function downloadPDF() {
    $('.print-none').css('display', 'none');
    //find table
    $('#print-table').find('table').addClass('table-border fs-10');
    $('#print-table').find('table').removeClass('table-bordered', 'table-striped');
    var doc = new jsPDF({
        orientation: 'p',
        unit: 'mm',
        format: 'a4',
        width: 210,
        height: 297,
        scale: 100,
        compress: true,
        precision: 2,
        lineHeight: 1.15,
        autoSize: false,
        printHeaders: true
    });
    doc.addHTML(document.getElementById('print-table'), function () {
        doc.save('sample-file.pdf');
    });
    $('.print-none').css('display', 'inline-block');
    //find table
    $('#print-table').find('table').removeClass('table-border fs-10');
    $('#print-table').find('table').addClass('table-bordered', 'table-striped');;

}


var validator = $(".validateForm").validate({
    errorPlacement: function (error, element) {
        if (element.hasClass('select-basic-single')) {
            error.insertAfter(element.next('.select2-container'));
        } else if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else if (element.prop('type') === 'radio') {
            error.insertAfter(element.parent().parent());
        } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.appendTo(element.parent().parent());
        } else {
            error.insertAfter(element);
        }
    },
    // rules: {
    //     barcode_qrcode: {
    //         rangelength: [8, 8],
    //     }
    // },

    // messages: {

    //     barcode_qrcode: {
    //         rangelength: 'The Barcode/QR-code must be at least 8 characters.'
    //     }
    // }
});

$(".validateEditForm").each(function () {
    $(this).validate({
        errorPlacement: function (error, element) {
            if (element.hasClass('select-basic-single')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio') {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            barcode_qrcode: {
                rangelength: [8, 8],
            }
        },

        messages: {

            barcode_qrcode: {
                rangelength: 'The Barcode/QR-code must be at least 8 characters.'
            }
        }
    });
})

$(document).ready(function () {
    //Predefined Date Ranges
    var start = moment();
    var end = moment();

    var changeDateRange = $('#date').val();

    if (changeDateRange) {
        start = moment(changeDateRange.split(' - ')[0], 'DD/MM/YYYY');
        end = moment(changeDateRange.split(' - ')[1], 'DD/MM/YYYY');
    }

    function date_range(start, end) {
        $('.account-date-range-daybook span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }

    $('.account-date-range-daybook').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, date_range);

    date_range(start, end);



    //Predefined Date Ranges
    var start = moment().subtract(30, 'days');
    var end = moment();

    var changeDateRange = $('#date').val();


    if (changeDateRange) {
        start = moment(changeDateRange.split(' - ')[0], 'DD/MM/YYYY');
        end = moment(changeDateRange.split(' - ')[1], 'DD/MM/YYYY');
    }

    function date_range(start, end) {
        $('.date-range span').val();
    }

    $('.account-date-range').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, date_range);

    date_range(start, end);

});

//Predefined Date Ranges For Stock
var start = moment();
var end = moment();

function cb(start, end) {
    $('.date-range').val('');
}

$('.date-range').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);


//number format
function bt_number_format(number) {
    var type = $('meta[name="floating_number"]').attr('content')
    var negative_symbol_type = $('meta[name="negative_amount_symbol"]').attr('content')
    var negative = false;

    if (number < 0) {
        negative = true;
        number = number * -1;

    }

    if (type == 1) {
        if (negative_symbol_type == 2) {
            if (negative) {
                return '(' + parseFloat(number).toFixed(0) + ')';
            } else {
                return parseFloat(number).toFixed(0);
            }
        } else {
            if (negative) {
                return parseFloat(-number).toFixed(0);
            } else {
                return parseFloat(number).toFixed(0);
            }
        }
    }

    if (type == 2) {
        if (negative_symbol_type == 2) {
            if (negative) {
                return '(' + parseFloat(number).toFixed(1) + ')';
            } else {
                return parseFloat(number).toFixed(1);
            }
        } else {
            if (negative) {
                return parseFloat(-number).toFixed(1);
            } else {
                return parseFloat(number).toFixed(1);
            }
        }
    }

    if (type == 3) {
        if (negative_symbol_type == 2) {
            if (negative) {
                return '(' + parseFloat(number).toFixed(2) + ')';
            } else {
                return parseFloat(number).toFixed(2);
            }
        } else {
            if (negative) {
                return parseFloat(-number).toFixed(2);
            } else {
                return parseFloat(number).toFixed(2);
            }
        }
    }

    if (type == 4) {
        if (negative_symbol_type == 2) {
            if (negative) {
                return '(' + parseFloat(number).toFixed(3) + ')';
            } else {
                return parseFloat(number).toFixed(3);
            }
        } else {
            if (negative) {
                return parseFloat(-number).toFixed(3);
            } else {
                return parseFloat(number).toFixed(3);
            }
        }
    }
}


$(document).ready(function () {
    var favicon = $('.favicon_show').attr('href');
    var collapse = $('.sidebar-mini').hasClass('sidebar-collapse')


    if (collapse) {
        $('.sidebar_brand_icon').attr('src', favicon);
    }
});

//Submit button disable when submitted
$(document).on('submit', 'form', function () {
    $('.submit_button').attr('disabled', 'disabled');
});

$(document).ready(function () {
    $("input").attr("autocomplete", "off");
});

function autocompleteOff() {
    $("input").attr("autocomplete", "off");
}

function expiryDate() {
    $(".expiry_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "slideDown",
    });
}

function convertToBarcode(Text) {
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $(".set-barcode").val(Text);
}

$(document).ready(function () {
    $('#all-clear').on('click', function (e) {
        e.preventDefault();

        var $input = $(this);

        var submit_url = $('#all-clear').attr('href');
        var csrf_val = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'GET',
            url: submit_url,
            data: {},
            headers: {
                'X-CSRF-TOKEN': csrf_val
            },

            success: function (res) {
                toastr.options = {
                    "showDuration": "300",
                    "hideDuration": "10000",
                    "timeOut": "5000",
                }

                setTimeout(function () {
                    location.reload();
                }, 1000);

                toastr.success("Application Cache, Routes Cache, Routes Clear, Config Cache, View Cache, Optimized and Storage Linked Successfully..!!");
            },
            beforeSend: () => elementLoader.show($input, 20, false),
            complete: () => elementLoader.hide($input),
        });

    });

});

$('.page-reload').click(function () {
    location.reload();
});
function preloader_ajax() {
    $(".page-loader-wrapper").show();
}


$(document).ready(function () {
    $("#StockAlertProductList").modal('show');
});


//Sidebar Collapsed Image
$(document).ready(function() {
    $('.collapsed-logo').css('display', 'none');

    $('#sidebarCollapse').on('click', function() {
        if ($('body').hasClass('sidebar-collapse')) {
            $('.collapsed-logo').css('display', 'block');
            $('.sidebar-logo').css('display', 'none');
        } else {
            $('.collapsed-logo').css('display', 'none');
            $('.sidebar-logo').css('display', 'block');
        }
    });

    $('.sidebar-bunker').hover(
        function() {
            if ($('body').hasClass('sidebar-collapse')) {
                $('.collapsed-logo').css('display', 'none');
                $('.sidebar-logo').css('display', 'block');
            }
        },
        function() {
            if ($('body').hasClass('sidebar-collapse')) {
                $('.collapsed-logo').css('display', 'block');
                $('.sidebar-logo').css('display', 'none');
            }
        }
    );
});

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
