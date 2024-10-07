"use strict";
$("#langName").change(function (event) {
    var value = $(this).val();
    $("#langCode").val(value);

    var name = $("#langName option:selected").text();
    $("#langNameText").val(name);
});

$(function () {
    "use strict";
    $(document).on("click", ".delete-confirm", function () {
        let url = $(this).data("route");
        let csrf = $(this).data("csrf");
        console.log(url);
        Swal.fire({
            title: get_phrases("Are you sure?"),
            text: get_phrases("You want to Delete Data"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    data: {
                        _token: csrf,
                        _method: "DELETE",
                    },
                    success: function (data) {
                        location.reload();
                    },
                });
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    });
});

("use strict");
// Stock list
$(document).ready(function () {
    var baseurl = $("#base_url").val();
    var id = $("#id").val();
    var table = $("#lang_table").DataTable({
        aaSorting: [[1, "asc"]],

        columnDefs: [
            {
                bSortable: false,
                aTargets: [0, 1, 2],
            },
        ],
        stateSave: true,
        processing: true,
        responsive: true,
        bServerSide: true,

        lengthMenu: [
            [10, 25, 50, 100, 250, 500, 1000, -1],
            [10, 25, 50, 100, 250, 500, 1000, "All"],
        ],

        dom: "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>",
        buttons: [
            {
                extend: "copy",
                text: get_phrases("Copy"),
                exportOptions: {
                    columns: [0, 1, 2], // Your Column value those you want
                },
                className: "btn-sm prints",
            },
            {
                extend: "csv",
                title: "Lang List",
                text: get_phrases("CSV"),
                exportOptions: {
                    columns: [0, 1, 2], // Your Column value those you want print
                },
                className: "btn-sm prints",
            },
            {
                extend: "excel",
                text: get_phrases("Excel"),
                exportOptions: {
                    columns: [0, 1, 2], // Your Column value those you want print
                },
                title: "Lang List",
                className: "btn-sm prints",
            },
            {
                extend: "pdf",
                text: get_phrases("PDF"),
                exportOptions: {
                    columns: [0, 1, 2], // Your Column value those you want print
                },
                title: "Lang List",
                className: "btn-sm prints",
            },
            {
                extend: "print",
                text: get_phrases("Print"),
                exportOptions: {
                    columns: [0, 1, 2], // Your Column value those you want print
                },
                title: "<center> Lang List</center>",
                className: "btn-sm prints",
            },
        ],

        ajax: {
            url: baseurl + "/language/lang/getAllData/" + id,
            type: "GET",
            data: {},
        },
        columns: [
            { data: "DT_RowIndex", class: "text-start" },
            { data: "lang_string", class: "text-start" },
            { data: "value" },
        ],
    });
});
var searchLabel = $(".dataTables_filter label");
searchLabel.html(
    get_phrases("Search") +
        `: <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example" autocomplete="off">`
);
