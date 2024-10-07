     
    var last_week_total_post = parseInt($("#last_week_total_post").val());
    var last_week_read_hit = parseInt($("#last_week_read_hit").val());
    var last_week_comments = parseInt($("#last_week_comments").val());

    var lang_posts = $("#lang_posts").val();
    var lang_read_hit = $("#lang_read_hit").val();
    var lang_comments = $("#lang_comments").val();
    var lang_performance = $("#lang_performance").val();

    var options1 = {
            series: [last_week_total_post, last_week_read_hit, last_week_comments],
            chart: {
                type: 'donut',
            },
            labels: [lang_posts, lang_read_hit, lang_comments], // Add custom labels here
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart1 = new ApexCharts(document.querySelector("#donut_Chart"), options1);
    chart1.render();

    //  End of Pie Chart
    
    //  Start of Bar Chart

    var months_names = JSON.parse($("#months_data").val());
    var read_hit_data = JSON.parse($("#read_hit_data").val());

    var options = {
        series: [{
            name: lang_read_hit,
            data: read_hit_data
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                colors: {
                ranges: [{
                    from: 0,
                    to: Number.MAX_VALUE,
                    color: '#288c6c'
                }],
                backgroundBarColors: ['#f3f4f5', '#fff']
                }
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: months_names,
        },
        yaxis: {
        title: {
            text: lang_performance
        }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                return val
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#forecast"), options);
    chart.render();

    //  End of Bar Chart