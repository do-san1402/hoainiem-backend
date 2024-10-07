@push('css')
@endpush
<div class="col-md-6 col-xl-6">
    <div class="card shadow-1">
      <div class="card-header">
        <div class="align-items-center d-flex flex-wrap gap-2 justify-content-between">
          <div>
            <h6 class="fs-16 fw-bold mb-0">Bank Accounts</h6>
          </div>
          <div class="text-end">
            <div id="bankaccountsrange" class="d-flex align-items-center predefined bg-white-smoke border-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 20" fill="none">
                <path d="M15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5 1V5" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M1 9H17" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 13H9" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9 13V16" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span id="bankaccountsDates" class="date-arange"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body" id="backAccount" data-url="{{route('bankAndCashBalance')}}">
        <h5 class="mb-2 fs-16 fw-bold">Bank</h5>
        <div class="d-flex align-items-center justify-content-between bg-white-smoke rounded-3 fs-17 p-3 mb-4">
          <p class="mb-0 fw-semi-bold">In RetailerPos</p>
          <p class="mb-0 fw-semi-bold" id="bankBalance"></p>
        </div>
        <h5 class="mb-2 fs-16 fw-bold">Cash and cash equivalents</h5>
        <div class="d-flex align-items-center justify-content-between bg-white-smoke rounded-3 fs-17 p-3 mb-4">
          <p class="mb-0 fw-semi-bold">In RetailerPos</p>
          <p class="mb-0 fw-semi-bold" id="cashBalance"></p>
        </div>
        <div class="d-flex align-items-center justify-content-between bg-white-smoke rounded-3 fs-17 p-3 mb-2">
          <p class="mb-0 fw-semi-bold">Total</p>
          <p class="mb-0 fw-bold" id="bankAndCashBalance"></p>
        </div>
      </div>
    </div>
  </div>
@push('js')

<script>

    // bankaccountsrange
    var start = moment().subtract(29, "days");
        var end = moment();

        function newDateRHM(start, end) {
            $("#bankaccountsrange span").html(start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY"));
        }
        $("#bankaccountsrange").daterangepicker({
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
    function updateChartFive(dateRange) {
        var url  = $('#backAccount').data('url');
        var csrf = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                url: url,
                type: 'POST',
                data: {
                    date: dateRange,
                    _token: csrf,
                },
                success: function(d) {
                    $('#bankBalance').text(d.bankBalance);
                    $('#cashBalance').text(d.cashBalance);
                    $('#bankAndCashBalance').text(d.totalBalance);

                },
                error: function(d) {
                    console.log(d);
                }
            });

    }

    // Initialize the chartThere when the page loads
    $(document).ready(function() {
            updateChartFive($('#bankaccountsDates').text());
            // Handle date range change event
            $('#bankaccountsrange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var dateRange = startDate + ' - ' + endDate;
                updateChartFive(dateRange);
            });
        });
</script>
@endpush
