$(function() {
    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $('.select-sub').click(function() {
        console.log($(this).parents('text-center').parents('.sub-select'));
        $(this).parents().parents('.sub-select').find('.permissions input[type=checkbox]').prop('checked', $(this)
            .prop('checked'));
    });
});
