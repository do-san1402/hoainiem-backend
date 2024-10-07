$(document).ready(function () {
    setTimeout(function () {
        $('.page-loader-wrapper').fadeOut();
    }, 50);
    var info = $('table tbody tr');
    info.click(function () {
        var email = $(this).children().first().text();
        var password = $(this).children().first().next().text();

        $("input[type=email]").val(email);
        $("input[type=password]").val(password);
    });
});