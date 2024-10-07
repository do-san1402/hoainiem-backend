@push('css')
@endpush
<div class="col-md-6 col-xl-6">
    <div class="card shadow-1">
        <div class="card-header">
            <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
                <div>
                    <h6 class="fs-16 fw-bold mb-0 d-flex align-items-center"><span class="vr_line me-2"></span> Cashier
                        Wise Sale</h6>
                </div>
                <div class="text-end">
                    <div id="cashiersalerange" class="d-flex align-items-center predefined bg-white-smoke border-0">
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
                        <span id="cashiersaleDates" class="date-arange"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="cashierchart" data-url="{{route('cashierWiseSale')}}"></div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // cashiersalerange
        var start = moment().subtract(29, "days");
        var end = moment();

        function prMMDD(start, end) {
            $("#cashiersalerange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#cashiersalerange").daterangepicker({
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
            prMMDD
        );
        prMMDD(start, end);

        // Initialize the chartSeven and rootSeven element once when the page loads
        var chartSeven = null;
        var rootSeven = null;
        var legendSeven = null;

        function initializeChartSeven() {

            am5.ready(function() {
                // Create rootSeven element
                rootSeven = am5.Root.new("cashierchart");

                // Set themes
                rootSeven.setThemes([am5themes_Animated.new(rootSeven)]);

                // Create chartSeven
                chartSeven = rootSeven.container.children.push(
                    am5percent.PieChart.new(rootSeven, {
                        layout: rootSeven.verticalLayout,
                    })
                );

                // Create series
                var series = chartSeven.series.push(
                    am5percent.PieSeries.new(rootSeven, {
                        valueField: "value",
                        categoryField: "name",
                    })
                );

                series.get("colors").set("colors", [am5.color(0x188753), am5.color(0x385c6b), am5.color(0xeeeeee)]);

                // Disabling labels and ticks
                series.labels.template.set("visible", false);
                series.ticks.template.set("visible", false);

                // Create legend
                legendSeven = chartSeven.children.push(
                    am5.Legend.new(rootSeven, {
                        centerX: am5.percent(50),
                        x: am5.percent(50),
                        marginTop: 15,
                        marginBottom: 15,
                    })
                );

                // legend.data.setAll(series.dataItems);

                // Play initial series animation
                series.appear(1000, 100);
            });

        }

        // Function to update the chartSeven with new data based on the date range
        function updateChartSeven(dateRange) {
            var url = $('#cashierchart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartSeven) {
                initializeChart();
            }

            // Set up data
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    date: dateRange,
                    _token: csrf,
                },
                success: function(d) {
                    chartSeven.series.getIndex(0).data.setAll(d); // Update the series data
                    legendSeven.data.setAll(chartSeven.series.getIndex(0).dataItems); // Update the legend data
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartSeven when the page loads
        $(document).ready(function() {
            initializeChartSeven();
            updateChartSeven($('#cashiersaleDates').text());

            // Handle date range change event
            $('#cashiersalerange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartSeven(dateRange);
            });
        });
    </script>
@endpush
