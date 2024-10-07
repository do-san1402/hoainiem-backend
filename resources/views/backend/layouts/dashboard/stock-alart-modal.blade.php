@push('css')
@endpush
@if ($stockAlertProductCount > 0)
    @if (Session::get('login_successful'))
        <!-- Your success modal HTML code goes here -->
        <div class="modal fade" id="StockAlertProductList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="counterRegisterLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="StockAlertProductListLabel">
                            {{ localize('stock_alert_product_list') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table display table-bordered align-middle fs-14">
                            <thead class="align-middle">
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('category_name') }}</th>
                                    <th>{{ localize('product_name') }}</th>
                                    <th>{{ localize('minimum_qty_alert') }}</th>
                                    <th>{{ localize('stock') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockAlertProductList as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->minimum_qty_alert }}</td>
                                        <td>{{ $item->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">{{ localize('close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clear the flag to prevent showing the modal on subsequent page loads -->
        <?php Session::forget('login_successful'); ?>
    @endif
@endif

@push('js')
@endpush
