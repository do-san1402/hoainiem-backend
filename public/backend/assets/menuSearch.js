$(document).ready(function () {
    $("#search").keyup(function () {
        var filter = $(this).val();
        $(`nav li:not(.sidebar-search)`).each(function (index, element) {
          const item = $(element);
          const parentListIsNested = item.closest('ul').hasClass('nav-second-level');

          if (item.text().match(new RegExp(filter, 'gi'))) {
            item.fadeIn();
            if (parentListIsNested){
              item.closest('ul').addClass('in');
            }
          } else {
            item.fadeOut();
            if (parentListIsNested){
              item.closest('ul').removeClass('in');
            }
          }
        });
    });
});
