$(document).ready(function() {
    "use strict";

    $(document).on("click", ".update-page-status", function () {
        let url = $(this).data("route");
        let csrf = $(this).data("csrf");

        Swal.fire({
            title: get_phrases("Are you sure?"),
            text: get_phrases("You want to update status"),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: url,
                    data: {
                        _token: csrf,
                        _method: "PUT",
                    },
                    success: function (data) {
                        $('#page-table').DataTable().ajax.reload();
                    },
                });
                Swal.fire("Updated!", "Status has been updated.", "success");
            }
        });
    });

});
