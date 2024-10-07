("use strict");

/**
 * update callback function
 */
let showCallBackData = function (response) {
    let data = response.data;

    $(document).find('#add_gallery').html('');
};

/**
 * update callback function
 */
let showCallBackUpdateData = function (response) {
    let data = response.data;

    $(document).find('#add_gallery').html('');
    let redirect_url = $(document).find('#news-post-form').attr('data-redirect');

    setTimeout(() => {
        window.location.href = redirect_url;
    }, 2000);
};

$(document).ready(function () {
    $(document).on("submit", "#search-position-form", function (e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        var action = $(form).attr("action");
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
                    var obj = response.data[key];

                    news_position_result += `
                        <tr>
                            <td>${obj?.news_mst?.title ?? ""}</td>
                            <td>
                                <input type="number" name="position[${obj.id}]"
                                    value="${
                                        obj.position
                                    }" class="form-control">
                            </td>
                            <td>
                                <a href="#" onclick="return confirm('Do you want to delete this ?');"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
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

    $(document).on("click", "#add-photo-gallery-button", function () {
        let current_image_div =  $("#add_gallery").attr('data-div_id');

        let add_gallery_image_html = $("#add_gallery_image_div").html();

        const regex = /SetDivId/gi;

        let div_html = add_gallery_image_html.replace(regex, current_image_div);

        $("#add_gallery").append(div_html);

        current_image_div++;

        $("#add_gallery").attr('data-div_id', current_image_div);
    });

    $(document).on("click", ".delete-photo-gallery-button", function () {
        $(this).closest(".gallery_image_div").remove();
    });
});
