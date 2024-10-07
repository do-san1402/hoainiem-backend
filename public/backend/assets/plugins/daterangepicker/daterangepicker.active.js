$(document).ready(function () {
    "use strict"; // Start of use strict

    //Simple Date Range Picker With a Callback
    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        "applyButtonClasses": "btn-success",
        "cancelClass": "btn-light"
    }, function (start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    //Date Range Picker With Times
    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        "applyButtonClasses": "btn-success",
        "cancelClass": "btn-light",
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'M/DD hh:mm A'
        }
    });

    // Birthday Date Picker
    $('input[name="birthday"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function (start, end, label) {
        var years = moment().diff(start, 'years');
        alert("You are " + years + " years old!");
    });

    //Predefined Date Ranges
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
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


    //Predefined Date Ranges For Stock
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#stock-report-range').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
    }

    $('#stock-report-range').daterangepicker({
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


    //Predefined Date Ranges For Stock
    var dtStart = moment();
    var dtEnd = moment();

    function cd(dtStart, dtEnd) {
        $('.date-range').val('');
    }

    $('.date-range').daterangepicker({
        startDate: dtStart,
        endDate: dtEnd,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    cd(dtStart, dtEnd);

    //Predefined Date Ranges For receive-date-range
    function receiveDateRange(dtStart, dtEnd) {
        $('.receive-date-range').val('');
    }

    $('.receive-date-range').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
    receiveDateRange(start, end);

    //Predefined Date Ranges For receive-date-range
    function purchaseDateRange(dtStart, dtEnd) {
        $('.purchase-date-range').val('');
    }
    $('.purchase-date-range').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
    purchaseDateRange(start, end);

    //Input Initially Empty
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        "drops": "up",
        "applyButtonClasses": "btn-success",
        "cancelClass": "btn-light",
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

});
