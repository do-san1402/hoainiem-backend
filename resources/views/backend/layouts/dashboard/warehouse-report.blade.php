@push('css')

@endpush
<div class="col-xl-6">
    <div class="card shadow-1">
      <div class="card-header">
        <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
          <div>
            <h6 class="fs-16 fw-bold mb-0">Outlet Report</h6>
          </div>
          <div class="text-end">
            <div id="warehouserange" class="d-flex align-items-center predefined bg-white-smoke border-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 20" fill="none">
                <path d="M15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M1 9H17" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 13H9" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9 13V16" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span id="warehouseDates" class="date-arange"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="warehousechart" data-url="{{route('warehouseWiseStock')}}"></div>
      </div>
    </div>
  </div>

@push('js')
<script>

    var start = moment().subtract(29, "days");
    var end = moment();

    function newDateR(start, end) {
        $("#warehouserange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
    }
    $("#warehouserange").daterangepicker({
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
        newDateR
    );
    newDateR(start, end);

    // Initialize the chartFour and rootFourFour element once when the page loads
    var chartFour = null;
        var rootFour = null;

        function initializeChartFour() {
            am5.ready(function () {
    // Create rootFour element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    rootFour = am5.Root.new("warehousechart");

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    rootFour.setThemes([am5themes_Animated.new(rootFour)]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    chartFour = rootFour.container.children.push(
        am5xy.XYChart.new(rootFour, {
            panX: false,
            panY: false,
            layout: rootFour.verticalLayout,
        })
    );

    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chartFour.children.push(
        am5.Legend.new(rootFour, {
            centerX: am5.p50,
            x: am5.p50,
        })
    );


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var yAxis = chartFour.yAxes.push(
        am5xy.CategoryAxis.new(rootFour, {
            categoryField: "country",
            renderer: am5xy.AxisRendererY.new(rootFour, {
                inversed: true,
                cellStartLocation: 0.1,
                cellEndLocation: 0.9,
            }),
        })
    );

    // yAxis.data.setAll(data);

    var xAxis = chartFour.xAxes.push(
        am5xy.ValueAxis.new(rootFour, {
            renderer: am5xy.AxisRendererX.new(rootFour, {
                strokeOpacity: 0.1,
            }),
            min: 0,
        })
    );

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    function createSeries(field, name) {
        var series = chartFour.series.push(
            am5xy.ColumnSeries.new(rootFour, {
                name: name,
                xAxis: xAxis,
                yAxis: yAxis,
                valueXField: field,
                categoryYField: "country",
                sequencedInterpolation: true,
                tooltip: am5.Tooltip.new(rootFour, {
                    pointerOrientation: "horizontal",
                    labelText: "{categoryY}: {valueX}",
                }),
            })
        );

        series.columns.template.set(
            "fillGradient",
            am5.LinearGradient.new(rootFour, {
                stops: [
                    {
                        color: am5.color(0x188753),
                    },
                    {
                        color: am5.color(0x188753),
                    },
                ],
                rotation: 90,
            })
        );

        series.columns.template.setAll({
            height: am5.p100,
            strokeOpacity: 0,
        });

        series.bullets.push(function () {
            return am5.Bullet.new(rootFour, {
                locationX: 1,
                locationY: 0.5,
                sprite: am5.Label.new(rootFour, {
                    centerY: am5.p50,
                    text: "{valueX}",
                    populateText: true,
                }),
            });
        });

        series.bullets.push(function () {
            return am5.Bullet.new(rootFour, {
                locationX: 1,
                locationY: 0.5,
                sprite: am5.Label.new(rootFour, {
                    centerX: am5.p100,
                    centerY: am5.p50,
                    text: "{name}",
                    fill: am5.color(0xffffff),
                    populateText: true,
                }),
            });
        });

        series.appear();

        return series;
    }

    createSeries("value");
    // createSeries("expenses", "Expenses");

    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chartFour.children.push(
        am5.Legend.new(rootFour, {
            centerX: am5.p50,
            x: am5.p50,
        })
    );

    legend.data.setAll(chartFour.series.values);

    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chartFour.set(
        "cursor",
        am5xy.XYCursor.new(rootFour, {
            behavior: "zoomY",
        })
    );
    cursor.lineY.set("forceHidden", true);
    cursor.lineX.set("forceHidden", true);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chartFour.appear(1000, 100);
}); // end am5.ready()

        }

        // Function to update the chartFour with new data based on the date range
        function updateChartFour(dateRange) {
            var url = $('#warehousechart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartFour) {
                initializeChartFour();
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
                    chartFour.yAxes.getIndex(0).data.setAll(d);
                    chartFour.series.getIndex(0).data.setAll(d);
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartFour when the page loads
        $(document).ready(function() {
            initializeChartFour();
            updateChartFour($('#warehouseDates').text());

            // Handle date range change event
            $('#warehouserange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartFour(dateRange);
            });
        });

</script>

@endpush
