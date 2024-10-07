@push('css')
@endpush
<div class="col-xl-6">
    <div class="card shadow-1">
        <!-- <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-16 fw-bold mb-0">Income vs Expense</h6>
                </div>
                <div>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <p class="mb-1 fw-semi-bold">Profit :</p>
                        <h5 class="mb-1 fw-bold" id="todayProfit"></h5>
                        <div class="bg-success rounded-pill p-1" id="upOrDown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="15" viewBox="0 0 8 10"
                                fill="none">
                                <path
                                    d="M0.910457 4.30885C0.702177 4.52478 0.364489 4.52478 0.15621 4.30885C-0.0520699 4.09292 -0.0520699 3.74283 0.15621 3.5269L3.24575 0.323893C3.66231 -0.107964 4.33769 -0.107965 4.75425 0.323893L7.84379 3.5269C8.05207 3.74283 8.05207 4.09292 7.84379 4.30885C7.63551 4.52478 7.29782 4.52478 7.08954 4.30885L4.53333 1.65876V9.44708C4.53333 9.75245 4.29455 10 4 10C3.70545 10 3.46667 9.75245 3.46667 9.44708V1.65876L0.910457 4.30885Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div>
                            <p class="mb-0" id="incomePercentage"></p>
                            <p class="mb-0">Than last Day</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="income-circle"></div>
                            <span class="fw-bold" id="totalIncomeChart"></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="expense-circle"></div>
                            <span class="fw-bold" id="totalExpenseChart"></span>
                        </div>
                    </div>
                </div>
                <div class="overflow-auto">
                    <div id="incomeexpenserange" class="d-flex align-items-center predefined bg-white-smoke border-0">
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
                        <span id="incomeexpenseDates" class="date-arange"></span>
                    </div>
                </div>
            </div>
        </div> -->

          <div class="card-header d-flex flex-column gap-2">
                        <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
                          <div>
                            <h6 class="fs-16 fw-bold mb-0">Income vs Expense</h6>
                          </div>
                          <div class="text-end">
                            <div id="incomeexpenserange" class="predefined bg-white-smoke d-flex align-items-center border-0">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 20" fill="none">
                                <path d="M15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 9H17" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 13H9" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 13V16" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                              &nbsp; <span></span>
                            </div>
                          </div>
                        </div>
                        <div>
                          <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                              <div class="profit-circle"></div>
                              <span class="fw-bold">$12,456.00 (Profit)</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between gap-2">
                              <div class="income-circle"></div>
                              <span class="fw-bold">$10,345.00 (Income)</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between gap-2">
                              <div class="expense-circle"></div>
                              <span class="fw-bold">$10,345.00 (Expense)</span>
                            </div>
                          </div>
                        </div>
                      </div>


        <div class="card-body">
            <div id="incomeexpensechart" data-url="{{route('incomeExpense')}}"></div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // incomeexpenserange
        var start = moment().subtract(7, "days");
        var end = moment();

        function newDateR(start, end) {
            $("#incomeexpenserange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#incomeexpenserange").daterangepicker({
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



        // Initialize the chartThere and rootThereThere element once when the page loads
        var chartThere = null;
        var rootThere = null;

        function initializeChartThere() {

            rootThere = am5.Root.new("incomeexpensechart");

            rootThere.setThemes([am5themes_Animated.new(rootThere)]);

            chartThere = rootThere.container.children.push(
                am5xy.XYChart.new(rootThere, {
                    panX: true,
                    panY: true,
                    wheelY: "zoomX",
                    layout: rootThere.verticalLayout,
                })
            );


            // Create Y-axis
            var yAxis = chartThere.yAxes.push(
                am5xy.ValueAxis.new(rootThere, {
                    extraTooltipPrecision: 1,
                    renderer: am5xy.AxisRendererY.new(rootThere, {}),
                })
            );

            // Create X-Axis
            var xAxis = chartThere.xAxes.push(
                am5xy.DateAxis.new(rootThere, {
                    baseInterval: {
                        timeUnit: "day",
                        count: 1
                    },
                    renderer: am5xy.AxisRendererX.new(rootThere, {
                        minGridDistance: 20,
                    }),
                })
            );

            // Create series
            function createSeries(name, field) {
                var series = chartThere.series.push(
                    am5xy.SmoothedXLineSeries.new(rootThere, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: field,
                        valueXField: "date",
                        tooltip: am5.Tooltip.new(rootThere, {}),
                    })
                );

                series.strokes.template.setAll({
                    strokeWidth: 2,
                    shadowColor: am5.color(0x000000),
                    shadowBlur: 10,
                    shadowOffsetX: 10,
                    shadowOffsetY: 10,
                    shadowOpacity: 0.5,
                });

                series.bullets.push(function() {
                    return am5.Bullet.new(rootThere, {
                        sprite: am5.Circle.new(rootThere, {
                            radius: 5,
                            fill: series.get("fill"),
                            shadowColor: am5.color(0x000000),
                            shadowBlur: 10,
                            shadowOffsetX: 10,
                            shadowOffsetY: 10,
                            shadowOpacity: 0.3,
                        }),
                    });
                });

                series.get("tooltip").label.set("text", "[bold]{name}[/]\n{valueX.formatDate()}: {valueY}");
            }

            createSeries("Series #1", "value");
            createSeries("Series #2", "valueTwo");

            // Add cursor
            chartThere.set(
                "cursor",
                am5xy.XYCursor.new(rootThere, {
                    behavior: "zoomXY",
                    xAxis: xAxis,
                })
            );

            xAxis.set(
                "tooltip",
                am5.Tooltip.new(rootThere, {
                    themeTags: ["axis"],
                })
            );

            yAxis.set(
                "tooltip",
                am5.Tooltip.new(rootThere, {
                    themeTags: ["axis"],
                })
            );
        }

        // Function to update the chartThere with new data based on the date range
        function updateChartThere(dateRange) {
            var url = $('#incomeexpensechart').data('url');
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if (!chartThere) {
                initializeChartThere();
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
                    let dataChart = d.chartData.map (function (item) {
                        return {
                            date: new Date(item.date).getTime(),
                            value: item.value,
                            valueTwo: item.valueTwo,
                        }
                    });
                    chartThere.series.getIndex(0).data.setAll(dataChart);
                    chartThere.series.getIndex(1).data.setAll(dataChart);

                    $("#todayProfit").text(d.profit);
                    $("#incomePercentage").text(d.incomePercentage);
                    $("#totalIncomeChart").text(d.income);
                    $("#totalExpenseChart").text(d.expense);

                    if (d.upOrDown == true) {
                        $("#upOrDown").removeClass('bg-danger').addClass('bg-success');
                    } else if (d.upOrDown == false) {
                        $("#upOrDown").removeClass('bg-success').addClass('bg-danger');
                        $("#upOrDown svg").css('transform', 'rotate(180deg)');
                    }else
                    {
                        $("#upOrDown").removeClass('bg-danger').addClass('bg-info');
                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });
        }

        // Initialize the chartThere when the page loads
        $(document).ready(function() {
            initializeChartThere();
            updateChartThere($('#incomeexpenseDates').text());

            // Handle date range change event
            $('#incomeexpenserange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartThere(dateRange);
            });
        });
    </script>

<script>
    // Create root and chart
    var root = am5.Root.new("incomeexpensechart");

    root.setThemes([am5themes_Animated.new(root)]);

    var chart = root.container.children.push(
      am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelY: "zoomX",
        layout: root.verticalLayout,
      })
    );

    // Define data
    var data = [
      {
        date: new Date(2021, 0, 1).getTime(),
        value: 1,
        value2: 5,
        value3: 3,
      },
      {
        date: new Date(2021, 0, 2).getTime(),
        value: 3,
        value2: 2,
        value3: 4,
      },
      {
        date: new Date(2021, 0, 3).getTime(),
        value: 1,
        value2: 3,
        value3: 2,
      },
      {
        date: new Date(2021, 0, 4).getTime(),
        value: 4,
        value2: 1,
        value3: 2,
      },
      {
        date: new Date(2021, 0, 5).getTime(),
        value: 5,
        value2: 2,
        value3: 4,
      },
      {
        date: new Date(2021, 0, 6).getTime(),
        value: 1,
        value2: 4,
        value3: 2,
      },
      {
        date: new Date(2021, 0, 7).getTime(),
        value: 5,
        value2: 2,
        value3: 1,
      },
    ];

    // Create Y-axis
    var yAxis = chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        extraTooltipPrecision: 1,
        renderer: am5xy.AxisRendererY.new(root, {}),
      })
    );

    // Create X-Axis
    var xAxis = chart.xAxes.push(
      am5xy.DateAxis.new(root, {
        baseInterval: { timeUnit: "day", count: 1 },
        renderer: am5xy.AxisRendererX.new(root, {
          minGridDistance: 20,
        }),
      })
    );

    // Create series
    function createSeries(name, field) {
      var series = chart.series.push(
        am5xy.SmoothedXLineSeries.new(root, {
          name: name,
          xAxis: xAxis,
          yAxis: yAxis,
          valueYField: field,
          valueXField: "date",
          tooltip: am5.Tooltip.new(root, {
            pointerOrientation: "horizontal",
            labelText: "[bold]{name}[/]\n{categoryX}: {valueY}",
          }),
        })
      );

      series.strokes.template.setAll({
        strokeWidth: 2,
        shadowColor: am5.color(0x000000),
        shadowBlur: 10,
        shadowOffsetX: 10,
        shadowOffsetY: 10,
        shadowOpacity: 0.5,
      });

      series.bullets.push(function () {
        return am5.Bullet.new(root, {
          sprite: am5.Circle.new(root, {
            radius: 5,
            fill: series.get("fill"),
            shadowColor: am5.color(0x000000),
            shadowBlur: 10,
            shadowOffsetX: 10,
            shadowOffsetY: 10,
            shadowOpacity: 0.3,
          }),
        });
      });

      series.get("tooltip").label.set("text", "[bold]{name}[/]\n{valueX.formatDate()}: {valueY}");
      series.data.setAll(data);
    }

    chart.get("colors").set("colors", [am5.color(0x198754), am5.color(0x28bf94), am5.color(0xe33535)]);

    createSeries("Profit", "value");
    createSeries("Income", "value2");
    createSeries("Expense", "value3");

    // Add cursor

    chart.set(
      "cursor",
      am5xy.XYCursor.new(root, {
        behavior: "zoomXY",
        xAxis: xAxis,
      })
    );

    xAxis.set(
      "tooltip",
      am5.Tooltip.new(root, {
        themeTags: ["axis"],
      })
    );

    yAxis.set(
      "tooltip",
      am5.Tooltip.new(root, {
        themeTags: ["axis"],
      })
    );
  </script>

  
@endpush
