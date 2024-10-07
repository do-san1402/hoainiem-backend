@push('css')

@endpush
<div class="col-xl-6">
    <div class="card shadow-1">
      <div class="card-header">
        <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
          <div>
            <h6 class="fs-16 fw-bold mb-0">Most Selling Product</h6>
          </div>
          <div class="text-end">
            <div id="mostsellingrange" class="d-flex align-items-center predefined bg-white-smoke border-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 20" fill="none">
                <path d="M15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M1 9H17" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 13H9" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9 13V16" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span id="mostsellingDates" class="date-arange"></span>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="card-body" id="mostSallingProduct" data-url="{{route('mostSellingProduct')}}"> --}}
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered basic">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Today</th>
                <th>Weekly</th>
                <th>All Time</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
              <tr>
                <td>Apple iPhone 8 White...</td>
                <td>5000</td>
                <td>Grocery</td>
                <td>50</td>
                <td>500</td>
                <td>5000</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
  @push('js')
  <script>

    // mostsellingrange
    var start = moment().subtract(29, "days");
        var end = moment();

        function newDateRHM(start, end) {
            $("#mostsellingrange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#mostsellingrange").daterangepicker({
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
            newDateRHM
        );
        newDateRHM(start, end);

    // Update chart there
    function updateChartEight(dateRange) {
        var url  = $('#mostSallingProduct').data('url');
        var csrf = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                url: url,
                type: 'POST',
                data: {
                    date: dateRange,
                    _token: csrf,
                },
                success: function(d) {
                    d.map(function(a) {
                        $('#mostSallingProduct').append(`
                            <div class="d-flex align-items-center product_list py-2">
                                <div>
                                    <p class="mb-1 fw-semi-bold fs-16">${a.product_name} ${a.product_model ? ' (' + a.product_model +')' : ''}</p>
                                    <p class="mb-1 fw-semi-bold fs-16 category_color">${a.category_name}</p>
                                </div>
                            </div>
                        `);
                    });

                },
                error: function(d) {
                    console.log(d);
                }
            });

    }

    // Initialize the chartThere when the page loads
    $(document).ready(function() {
            updateChartEight($('#mostsellingDates').text());
            // Handle date range change event
            $('#mostsellingrange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartEight(dateRange);
            });
        });
</script>
  @endpush
