"use strict";

/**
 * Report Create callback function
 */
var showCallBackData = function (response) {
    let data = response.data;
};

/**
 * Report Create callback function
 */
var showCallBackViewData = function (response) {
    let data = response.data;
    let title = data.title != null ? data.title : "";

    $("#thumb_height").val(280);
    $("#thumb_width").val(400);
    $("#large_height").val(451);
    $("#large_width").val(643);

    let html = `
        <div class="m-2 photo-library-element"
            data-id="${data.uuid}"
            data-actual_image_name="${data.actual_image_name}"
            data-thumb_image="${data.thumb_image_path}"
            data-caption="${title}">
            <p>${title}</p>
            <img class="img-responsive img-thumbnail photo-library-img"
                src="${data.thumb_image_path}"
                height="100" width="100"
                alt="${title}" />
        </div>
    `;

    $("#show-images").append(html);
};
