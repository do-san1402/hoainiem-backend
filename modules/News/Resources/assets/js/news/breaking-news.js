("use strict");

/**
 * Create callback function
 */
let showCallBackCreateData = function (response) {
    let data = response.data;
    $("#breakingNewsForm").find('input[name="_method"]').remove();

    let classes = $("#breakingNewsForm").attr('data-create_breaking_news');

    setTimeout(() => {
        $("#breakingNewsForm").find("#submitButton").html("Save");
        $("#breakingNewsForm").addClass(classes);
        $(".dataTable").DataTable().ajax.reload();
    }, 1500);

};

$(document).ready(function () {
    /**
     * Update breaking news model open
     */
    $(document).on("click", ".edit-breaking-news-button", function () {
        // set form value
        $("#breaking_news").html("");
        $("#submitButton").html("Update");

        $("#breakingNewsForm").attr("action", $(this).attr("data-action"));
        if (!$("#breakingNewsForm").find('input[name="_method"]').length) {
            $("#breakingNewsForm").prepend(
                '<input type="hidden" name="_method" value="patch" />'
            );
        }

        let form = $("#breakingNewsForm");
        form.removeClass('d-none');
        let formData = new FormData(
            document.querySelector("#breakingNewsForm")
        );

        // set form data by route
        setFormValue($(this).attr("data-route"), form, formData).then(
            (response) => {
                if (response) {
                    let title = JSON.parse(response.title);
                    $("#breaking_news").val(title.news_title);
                }
            }
        );
    });
});
