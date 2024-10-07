("use strict");

/**
 * Link callback function
 */
var showCallBackLinkData = function (response) {
    let data = response.data;
    if (data) {
        if (data.menu_content) {
            let menu_content = data.menu_content;
            let menuContentId = menu_content.id;

            let editRoute = $("#sortable").attr("data-edit-route");
            let updateRoute = $("#sortable").attr("data-update-route");
            let destroyRoute = $("#sortable").attr("data-destroy-route");

            editRoute = editRoute.replace("menu_content_param", menuContentId);
            updateRoute = updateRoute.replace(
                "menu_content_param",
                menuContentId
            );
            destroyRoute = destroyRoute.replace(
                "menu_content_param",
                menuContentId
            );

            $("#parent_id").append(
                new Option(menu_content.menu_level, menuContentId)
            );

            $("#sortable").append(`
                <div class="row msv" id="msv_div_${menuContentId}">
                    <div class="col-sm-10">
                        ${menu_content.menu_level}
                    </div>
                    <div class="col-sm-2 mbtn">
                        <button class="btn-primary btn edit-menu-content" type="button"
                            data-route="${editRoute}"
                            data-action="${updateRoute}" >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger delete-menu-content" type="button"
                            data-action="${destroyRoute}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" value="${menuContentId}" name="id[]">
                </div>
            `);
        }
        if (data.link) {
            let link = data.link;

            $("#links_level").append(`
                <label>
                    <input type="checkbox" name="content_id[]" value="${link.id}">
                    ${link.level}
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
            `);
        }
    }

    $("#link_modal").modal("hide");
};

/**
 * Category menu content callback function
 */
var showCallBackCategoryMenuContentData = function (response) {
    let data = response.data;
    $("#category_content_type").val("categories");

    setTimeout(() => {
        window.location.reload();
    }, 3000);
};

/**
 * Page menu content callback function
 */
var showCallBackPageMenuContentData = function (response) {
    let data = response.data;
    $("#page_content_type").val("pages");

    setTimeout(() => {
        window.location.reload();
    }, 3000);
};

/**
 * Link menu content callback function
 */
var showCallBackLinkMenuContentData = function (response) {
    let data = response.data;

    setTimeout(() => {
        window.location.reload();
    }, 3000);
};

/**
 * Menu content position callback function
 */
var showCallBackMenuContentPositionData = function (response) {
    let data = response.data;

    setTimeout(() => {
        window.location.reload();
    }, 3000);
};

/**
 * Menu content callback function
 */
var showCallBackMenuContentData = function (response) {
    let menu_content = response.data;
    if (menu_content) {
        let menuContentId = menu_content.id;

        let editRoute = $("#sortable").attr("data-edit-route");
        let updateRoute = $("#sortable").attr("data-update-route");
        let destroyRoute = $("#sortable").attr("data-destroy-route");

        editRoute = editRoute.replace("menu_content_param", menuContentId);
        updateRoute = updateRoute.replace("menu_content_param", menuContentId);
        destroyRoute = destroyRoute.replace(
            "menu_content_param",
            menuContentId
        );

        $(`#msv_div_${menuContentId}`).html(`
           <div class="col-sm-10">
                    ${menu_content.menu_level}
                </div>
                <div class="col-sm-2 mbtn">
                    <button class="btn-primary btn edit-menu-content" type="button"
                        data-route="${editRoute}"
                        data-action="${updateRoute}" >
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger delete-menu-content" type="button"
                        data-action="${destroyRoute}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <input type="hidden" value="${menuContentId}" name="id[]">
        `);
    }

    $("#update_modal").modal("hide");
};

$(document).ready(function () {
    $(document).on("click", "#add-new-link", function () {
        $("#link_modal").modal("show");
    });

    $("#sortable").sortable();
    $("#sortable").disableSelection();

    $(document).on("click", ".edit-menu-content", function () {
        let route = $(this).attr("data-route");
        let action = $(this).attr("data-action");
        let model_title = $(this).attr("data-model_title");

        $.ajax({
            type: "GET",
            url: route,
            cache: false,
            dataType: "json",
            success: function (response) {
                $("#update_modal").modal("show");
                $("#updateMenuContentForm").attr("action", action);

                let menuContent = response.data;
                $("#menu_content_level").val(menuContent.menu_level);
                $("#menu_content_slug").val(menuContent.slug);
                $("#menu_content_position").val(menuContent.menu_position);
                $("#menu_content_link").val(menuContent.link_url);
                $("#menu_content_parent_id")
                    .val(menuContent.parent_id)
                    .trigger("change.select2");
            },
            error: function (response) {},
        });
    });

    $(document).on("click", ".delete-menu-content", function () {
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
