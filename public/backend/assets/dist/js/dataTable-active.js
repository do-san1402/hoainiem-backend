(function ($) {
    "use strict";
    var tableBasic = {
        initialize: function () {
            this.basic();
        },
        basic: function () {
            $('.basic').DataTable({
                iDisplayLength: 8,
                bPaginate:false,
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        tableBasic.initialize();
    });

}(jQuery));
