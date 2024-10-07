("use strict");

/**
 * update callback function
 */
let showCallBackUpdateData = function (response) {
    let data = response.data;
};

$(document).ready(function () {
    $(document).on("submit", "#search-position-form", function (e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        var action = $(form).attr("action");
        var newsPositionDestroy = $(form).attr("data-position-delete-route");

        var queryString = new URLSearchParams(formData).toString();
        var url = action + "?" + queryString;
        $.ajax({
            type: "GET",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            async: false,
            success: function (response) {
                success_alert(response.message, response.title);
                $(document).find("#news-position-table > tbody").empty();
                let news_position_result = ``;

                for (const key in response.data) {
                    var newsPosition = response.data[key];

                    let positionDestroy = newsPositionDestroy.replace(':news_position_id', newsPosition.id);


                    news_position_result += `
                        <tr>
                            <td>${newsPosition?.news_mst?.title ?? ""}</td>
                            <td>
                                <input type="number" name="position[${newsPosition.id}]"
                                    value="${newsPosition.position}" class="form-control">
                            </td>
                            <td>
                                <button class="btn btn-danger delete-news-position" type="button"
                                    data-action="${positionDestroy}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        `;
                }

                $(document)
                    .find("#news-position-table > tbody")
                    .html(news_position_result);
            },
            error: function (response) {
                let data = response.responseJSON;
                error_alert(data.message, data.title);
            },
        });
    });

    $(document).on("click", ".delete-news-position", function () {
        const thisElement = $(this);
        let action = thisElement.attr("data-action");

        Swal.fire({
            title: "Do you want to delete?",
            confirmButtonText: "Yes",
            showDenyButton: true,
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: action,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader(
                            "X-CSRF-Token",
                            $('meta[name="csrf-token"]').attr("content")
                        );
                    },
                    type: "DELETE",
                    dataType: "json",
                    success: function (response) {
                        thisElement.parent().parent().remove();

                        success_alert(response.message, response.title);
                    },
                    error: function (response) {
                        let data = response.responseJSON;
                        error_alert(data.message, data.title);
                    },
                });
            }
        });
    });
});
