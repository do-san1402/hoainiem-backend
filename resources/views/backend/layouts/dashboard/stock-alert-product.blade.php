<div class="col-xl-6">
    <div class="card shadow-1">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-16 fw-bold mb-0">Stock Alert Report</h6>
                </div>
                <div class="text-end">
                    <div id="stockrange" class="predefined bg-white-smoke d-flex align-items-center border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 20"
                            fill="none">
                            <path
                                d="M15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3Z"
                                stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M5 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M1 9H17" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8 13H9" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M9 13V16" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        &nbsp; <span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive overflow-hidden">
                {{ $StockAlertReportDataTable->table() }}
            </div>
        </div>
    </div>
</div>
@push('js')
    {!! $StockAlertReportDataTable->scripts() !!}
    <script>
        var start = moment().subtract(29, "days");
        var end = moment();

        function sr(start, end) {
            $("#stockrange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }

        $("#stockrange").daterangepicker({
                startDate: start,
                endDate: end,
                showDropdowns: true,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf(
                        "month")],
                },
            },
            sr
        );

        sr(start, end);
        $(document).ready(function() {
            //on change date range
            $('#stockrange').on('apply.daterangepicker', function(ev, picker) {
                var start = picker.startDate.format('YYYY-MM-DD');
                var end = picker.endDate.format('YYYY-MM-DD');

                var table = $('#stock-alert-product-table');
                table.on('preXhr.dt', function(e, settings, data) {
                    data.from_date = start;
                    data.to_date = end;
                });
                table.DataTable().ajax.reload();
            });
        });
    </script>
@endpush
