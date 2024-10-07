$( document ).ready(function() {
    "use strict"
    $(".nav-tabs a").click(function() {
        var position = $(this).parent().position();
        var width = $(this).parent().width();
        $(".slider").css({
            "left": +position.left,
            "width": width
        });
    });
    var actWidth = $(".nav-tabs .active").width();
    var actPosition = $(".nav-tabs .active").position();
    $(".slider").css({
        "left": 25,
        "width": actWidth
    });

    var yourNavigation = $("#main-menu");
    var stickyDiv = "sticky";
    var yourHeader = $(".top-header").height();

    $(window).scroll(function () {
      if ($(this).scrollTop() > yourHeader) {
        yourNavigation.addClass(stickyDiv);
      } else {
        yourNavigation.removeClass(stickyDiv);
      }
    });

    //Navbar collapse hide
    $('.navbar-collapse .navbar-toggler').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });
});
