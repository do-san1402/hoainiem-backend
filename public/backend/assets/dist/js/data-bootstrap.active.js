(function($) {
    "use strict";
    var tableBootstrap4Style = {
        initialize: function() {
            this.bootstrap4Styling();
            this.bootstrap4Modal();
            this.print();
        },
        bootstrap4Styling: function() {
            $('.bootstrap4-styling').DataTable();
        },
        bootstrap4Modal: function() {
            $('.bootstrap4-modal').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
        },
        print: function() {
            var table = $('#example').DataTable({
                "lengthChange": true,
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                // dom: "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>",
                // dom: 'Bfrtip',
                // dom: 'B<"clear">lfrtip',
                buttons: [
                    // {
                    //     extend: 'print',
                    //     className: 'btn btn-success-soft me-1 shadow-none'
                    // },
                    {
                        extend: 'csv',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                    {
                        extend: 'copy',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                    // {
                    //     extend: 'pdf',
                    //     className: 'btn btn-success-soft me-1 shadow-none'
                    // },
                ]

            });
            
             table.buttons().container().appendTo('#example_wrapper .col-md-4:eq(0)');

             // New ID for DataTable which example2
             var table2 = $('#example2').DataTable({
                "lengthChange": true,
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                buttons: [
                    {
                        extend: 'csv',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                    {
                        extend: 'copy',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success-soft me-1 shadow-none'
                    },
                ]

            });
            
            table2.buttons().container().appendTo('#example_wrapper .col-md-4:eq(0)');
        }

    };
    // Initialize
    $(document).ready(function() {
        "use strict"; // Start of use strict
        tableBootstrap4Style.initialize();
    });

}(jQuery));
