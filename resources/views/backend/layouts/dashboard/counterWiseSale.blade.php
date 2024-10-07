@push('css')
@endpush
<div class="col-md-6 col-xl-6">
    <div class="card shadow-1">
        <div class="card-header">
            <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
                <div>
                    <h6 class="fs-16 fw-bold mb-0 d-flex align-items-center"><span class="vr_line me-2"></span> Counter
                        Wise Sale</h6>
                </div>
                <div class="text-end">
                    <div id="countersalerange" class="d-flex align-items-center predefined bg-white-smoke border-0">
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
                        <span id="countersaleDates" class="date-arange"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="counterchart" data-url="{{ route('counterWiseSale') }}"></div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // countersalerange
        var start = moment().subtract(29, "days");
        var end = moment();

        function newDateRHMX(start, end) {
            $("#countersalerange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#countersalerange").daterangepicker({
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
            newDateRHMX
        );
        newDateRHMX(start, end);
        // Initialize the chartSix and rootSixSix element once when the page loads
        var chartSix = null;
        var rootSix = null;

        function initializeChartSix() {
            am5.ready(function() {
                // Create rootSix element
                rootSix = am5.Root.new("counterchart");

                // Set themes
                rootSix.setThemes([am5themes_Animated.new(rootSix)]);

                // Create chartSix
                chartSix = rootSix.container.children.push(
                    am5xy.XYChart.new(rootSix, {
                        panX: true,
                        panY: true,
                    })
                );

                // Add cursor
                var cursor = chartSix.set("cursor", am5xy.XYCursor.new(rootSix, {}));
                cursor.lineY.set("visible", false);

                // Create axes
                var xRenderer = am5xy.AxisRendererX.new(rootSix, {
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

                var xAxis = chartSix.xAxes.push(
                    am5xy.CategoryAxis.new(rootSix, {
                        maxDeviation: 0.3,
                        categoryField: "counter",
                        renderer: xRenderer,
                        tooltip: am5.Tooltip.new(rootSix, {}),
                    })
                );

                var yAxis = chartSix.yAxes.push(
                    am5xy.ValueAxis.new(rootSix, {
                        maxDeviation: 0.3,
                        renderer: am5xy.AxisRendererY.new(rootSix, {
                            strokeOpacity: 0.1,
                        }),
                    })
                );

                // Create series
                var series = chartSix.series.push(
                    am5xy.ColumnSeries.new(rootSix, {
                        name: "Series 1",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "value",
                        sequencedInterpolation: true,
                        categoryXField: "counter",
                        tooltip: am5.Tooltip.new(rootSix, {
                            labelText: "{valueY}",
                        }),
                    })
                );

                series.columns.template.set(
                    "fillGradient",
                    am5.LinearGradient.new(rootSix, {
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
                    return chartSix.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chartSix.get("colors").getIndex(series.columns.indexOf(target));
                });

                // Make stuff animate on load
                series.appear(1000);
                chartSix.appear(1000, 100);
            });


        }

        // Function to update the chartSix with new data based on the date range
        function updateChartSix(dateRange) {
            var url = $('#counterchart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartSix) {
                initializeChartSix();
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
                    // Update the chartSix's data with the new data

                    chartSix.xAxes.getIndex(0).data.setAll(d); // Update the x-axis data
                    chartSix.series.getIndex(0).data.setAll(d); // Update the series data
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartSix when the page loads
        $(document).ready(function() {
            initializeChartSix();
            updateChartSix($('#countersaleDates').text());

            // Handle date range change event
            $('#countersalerange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartSix(dateRange);
            });
        });
    </script>
@endpush
