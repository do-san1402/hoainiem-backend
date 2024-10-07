<div class="col-xl-6">
    <div class="card shadow-1">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-16 fw-bold mb-0">Last 30 Days Sale</h6>
                </div>
                <div class="text-end">
                    <div id="salerange" class="predefined bg-white-smoke d-flex align-items-center border-0">
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
                        &nbsp; <span id="last30DayDateRange"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="saleschart" data-url="{{ route('last30daySales') }}"></div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // salerange
        var start = moment().subtract(29, "days");
        var end = moment();
        function sar(start, end) {
            $("#salerange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#salerange").daterangepicker(
            {
                startDate: start,
                endDate: end,
                showDropdowns: true,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
                },
            },
            sar
        );
        sar(start, end);


        // Initialize the chartOne and rootOne element once when the page loads
        var chartOne = null;
        var rootOne = null;

        function initializeChartOne() {
            am5.ready(function() {
                // Create the rootOne element only once
                rootOne = am5.Root.new("saleschart");
                rootOne.setThemes([am5themes_Animated.new(rootOne)]);

                rootOne.dateFormatter.setAll({
                    dateFormat: "yyyy-MM-dd",
                    dateFields: ["valueX"],
                });

                // Create chartOne
                chartOne = rootOne.container.children.push(
                    am5xy.XYChart.new(rootOne, {
                        focusable: true,
                        panX: true,
                        panY: true,
                    })
                );

                // Set up xAxis
                var xAxis = chartOne.xAxes.push(
                    am5xy.DateAxis.new(rootOne, {
                        maxDeviation: 0.1,
                        groupData: false,
                        baseInterval: {
                            timeUnit: "day",
                            count: 1,
                        },
                        renderer: am5xy.AxisRendererX.new(rootOne, {}),
                        tooltip: am5.Tooltip.new(rootOne, {}),
                    })
                );

                // Set up yAxis
                var yAxis = chartOne.yAxes.push(
                    am5xy.ValueAxis.new(rootOne, {
                        maxDeviation: 0.2,
                        renderer: am5xy.AxisRendererY.new(rootOne, {}),
                    })
                );

                // Add a LineSeries to the chartOne
                var series = chartOne.series.push(
                    am5xy.LineSeries.new(rootOne, {
                        minBulletDistance: 10,
                        connect: false,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "value",
                        valueXField: "date",
                        stroke: am5.color(0x0e9b2d),
                        tooltip: am5.Tooltip.new(rootOne, {
                            pointerOrientation: "horizontal",
                            labelText: "{valueY}",
                        }),
                    })
                );

                // Define fill gradient for the series
                series.fills.template.set(
                    "fillGradient",
                    am5.LinearGradient.new(rootOne, {
                        stops: [{
                                color: am5.color(0x31c752),
                            },
                            {
                                color: am5.color(0xedf7ed),
                            },
                        ],
                        rotation: 90,
                    })
                );

                series.fills.template.setAll({
                    visible: true,
                    fillOpacity: 1,
                });

                series.strokes.template.setAll({
                    strokeWidth: 2,
                });

                // Set up data processor to parse string dates
                series.data.processor = am5.DataProcessor.new(rootOne, {
                    dateFormat: "yyyy-MM-dd",
                    dateFields: ["date"],
                });

                // Add bullets to the series
                series.bullets.push(function() {
                    var circle = am5.Circle.new(rootOne, {
                        radius: 4,
                        fill: rootOne.interfaceColors.get("background"),
                        stroke: series.get("fill"),
                        strokeWidth: 2,
                        stroke: am5.color(0x0e9b2d),
                    });

                    return am5.Bullet.new(rootOne, {
                        sprite: circle,
                    });
                });

                // Add cursor
                var cursor = chartOne.set(
                    "cursor",
                    am5xy.XYCursor.new(rootOne, {
                        xAxis: xAxis,
                        behavior: "none",
                    })
                );
                cursor.lineY.set("visible", false);


                // Make stuff animate on load
                chartOne.appear(1000, 100);
            });
        }

        // Function to update the chartOne with new data based on the date range
        function updateChartOne(dateRangeOne) {
            var url = $('#saleschart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartOne) {
                initializeChartOne();
            }

            // Set up data
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    date: dateRangeOne,
                    _token: csrf,
                },
                success: function(d) {
                    // Update the chartOne's data with the new data
                    chartOne.series.getIndex(0).data.setAll(d);
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartOne when the page loads
        $(document).ready(function() {
            initializeChartOne();
            updateChartOne($('#last30DayDateRange').text());

            // Handle date range change event
            $('#salerange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRangeOne = startDate + ' - ' + endDate;
                updateChartOne(dateRangeOne);
            });
        });
    </script>
@endpush
