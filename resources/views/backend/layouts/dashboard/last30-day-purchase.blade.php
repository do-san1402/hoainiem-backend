@push('css')
@endpush
<div class="col-xl-6">
    <div class="card shadow-1">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-16 fw-bold mb-0">Last 30 Days Purchase</h6>
                </div>
                <div class="text-end">
                    <div id="purchaserange" class="bg-white-smoke d-flex align-items-center border-0">
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
                        &nbsp; <span id="last30DayPurchaseDateRange"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="purchasechart" data-url="{{route("last30dayPurchase")}}"></div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // purchaserange
        var start = moment().subtract(29, "days");
        var end = moment();

        function pr(start, end) {
            $("#purchaserange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#purchaserange").daterangepicker({
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
            pr
        );
        pr(start, end);

        // Initialize the chartTwo and rootTwo element once when the page loads
        var chartTwo = null;
        var rootTwo = null;

        function initializeChartTwo() {

            am5.ready(function() {
                // Create rootTwo element
                rootTwo = am5.Root.new("purchasechart");

                // Set themes
                rootTwo.setThemes([am5themes_Animated.new(rootTwo)]);

                // Create chartTwo
                chartTwo = rootTwo.container.children.push(
                    am5xy.XYChart.new(rootTwo, {
                        panX: true,
                        panY: true,
                    })
                );

                // Add cursor
                var cursor = chartTwo.set("cursor", am5xy.XYCursor.new(rootTwo, {}));
                cursor.lineY.set("visible", false);

                // Create axes
                var xRenderer = am5xy.AxisRendererX.new(rootTwo, {
                    minGridDistance: 30
                });
                xRenderer.labels.template.setAll({
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15,
                });

                xRenderer.grid.template.setAll({
                    location: 1,
                });

                var xAxis = chartTwo.xAxes.push(
                    am5xy.CategoryAxis.new(rootTwo, {
                        maxDeviation: 0.3,
                        categoryField: "date",
                        renderer: xRenderer,
                        tooltip: am5.Tooltip.new(rootTwo, {}),
                    })
                );

                var yAxis = chartTwo.yAxes.push(
                    am5xy.ValueAxis.new(rootTwo, {
                        maxDeviation: 0.3,
                        renderer: am5xy.AxisRendererY.new(rootTwo, {
                            strokeOpacity: 0.1,
                        }),
                    })
                );

                // Create series
                var series = chartTwo.series.push(
                    am5xy.ColumnSeries.new(rootTwo, {
                        name: "Series 1",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "value",
                        sequencedInterpolation: true,
                        categoryXField: "date",
                        tooltip: am5.Tooltip.new(rootTwo, {
                            labelText: "{valueY}",
                        }),
                    })
                );

                series.columns.template.set(
                    "fillGradient",
                    am5.LinearGradient.new(rootTwo, {
                        stops: [{
                                color: am5.color(0x188753),
                            },
                            {
                                color: am5.color(0xc5f5de),
                            },
                        ],
                        rotation: 90,
                    })
                );

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    shadowColor: am5.color(0x3f4040),
                    shadowBlur: 4,
                    shadowOffsetX: 4,
                    shadowOffsetY: 4,
                    shadowOpacity: 0.1,
                });

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    strokeOpacity: 0
                });
                series.columns.template.adapters.add("fill", function(fill, target) {
                    return chartTwo.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chartTwo.get("colors").getIndex(series.columns.indexOf(target));
                });

                // Make stuff animate on load
                series.appear(1000);
                chartTwo.appear(1000, 100);
            });
        }

        // Function to update the chartTwo with new data based on the date range
        function updateChartTwo(dateRange) {
            var url = $('#purchasechart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartTwo) {
                initializeChartTwo();
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
                    // Update the chartTwo's data with the new data

                    chartTwo.series.getIndex(0).data.setAll(d); // Update the series data
                    chartTwo.xAxes.getIndex(0).data.setAll(d); // Update the x-axis data
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartTwo when the page loads
        $(document).ready(function() {
            initializeChartTwo();
            updateChartTwo($('#last30DayPurchaseDateRange').text());

            // Handle date range change event
            $('#purchaserange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartTwo(dateRange);
            });
        });
    </script>
@endpush
