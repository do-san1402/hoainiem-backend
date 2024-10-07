<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait singleProductWarehouseWiseTrait {

    public function stock($product_id , $warehouse_id)
    {
        $date = Carbon::now()->format('Y-m-d');

        //raw query
        $stock = DB::select(
            "SELECT i.id, s.warehouse_id, w.name, i.product_name, i.product_model, i.category_id, i.price, i.cost, s.Open_Qty, s.delivered_qty, s.delivered_Amount, s.rece_qty, s.rece_Amount, s.pur_ret_qty, s.pur_ret_Amount, s.sale_ret_Qty, s.sale_ret_Amount, s.wastage_ret_qty, s.wastage_ret_Amount, s.adjustment_qty, s.transfer_qty
            FROM product_information i
            LEFT JOIN (
                SELECT t.product_id, t.warehouse_id, SUM(t.open_Qty) Open_Qty, SUM(t.delivered_qty) delivered_qty, SUM(t.delivered_Amount) delivered_Amount, SUM(t.rece_qty) rece_qty, SUM(t.rece_Amount) rece_Amount, SUM(t.pur_ret_qty) AS pur_ret_qty, SUM(t.pur_ret_Amount) AS pur_ret_Amount, SUM(t.sale_ret_Qty) sale_ret_Qty, SUM(t.sale_ret_Amount) AS sale_ret_Amount, SUM(t.wastage_ret_qty) wastage_ret_qty, SUM(t.wastage_ret_Amount) AS wastage_ret_Amount, SUM(t.adjustment_qty) adjustment_qty, SUM(t.transfer_qty) transfer_qty
                FROM (
                    SELECT p.product_id, p.warehouse_id, SUM(p.quantity) Open_Qty, 0 AS delivered_qty, 0 AS delivered_Amount, 0 rece_qty, 0 AS rece_Amount, 0 pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM opening_stocks p
                    WHERE p.opening_stock_date < '$date'
                    GROUP BY p.product_id , p.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 - SUM(d.quantity) Open_Qty, 0 AS delivered_qty, 0 AS delivered_Amount, 0 rece_qty, 0 AS rece_Amount, 0 pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM delivery_items p
                    LEFT JOIN delivery_item_details d ON p.id = d.delivery_id
                    WHERE p.delivery_date < '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, w.warehouse_id, SUM(w.warehouse_base_qty) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM receives p
                    LEFT JOIN receive_details d ON p.id = d.receive_id
                    LEFT JOIN receive_by_warehouses w on w.receive_id = p.id and d.product_id = w.product_id
                    WHERE p.receive_date < '$date'
                    GROUP BY d.product_id , w.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 - SUM(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM purchase_receive_returns p
                    LEFT JOIN purchase_receive_return_details d ON p.id = d.return_id
                    WHERE p.receive_date < '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, SUM(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM sale_returns p
                    LEFT JOIN sale_return_details d ON p.id = d.return_id
                    WHERE p.sale_date < '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, p.warehouse_id ,0 - SUM(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM wastages p
                    LEFT JOIN wastage_details d ON p.id = d.wastage_id
                    WHERE p.wastage_date < '$date'
                    GROUP BY d.product_id , p.warehouse_id
                    UNION ALL
                    SELECT d.product_id, p.warehouse_id, 0 - SUM(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 AS wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM adjustments p
                    LEFT JOIN adjustment_details d ON p.id = d.adjustment_id
                    WHERE p.adjustment_date < '$date'
                    GROUP BY d.product_id , p.warehouse_id
                    UNION ALL
                    SELECT d.product_id, p.from_warehouse_id as warehouse_id, 0 - SUM(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 AS wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM transfers p
                    LEFT JOIN transfer_details d ON p.id = d.transfer_id
                    WHERE p.transfer_date < '$date'
                    GROUP BY d.product_id , warehouse_id

                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 Open_Qty, SUM(d.quantity) AS delivered_qty, SUM(d.quantity * d.price) AS delivered_Amount, 0 rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM delivery_items p
                    LEFT JOIN delivery_item_details d ON p.id = d.delivery_id
                    WHERE p.delivery_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, w.warehouse_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, SUM(w.warehouse_base_qty) rece_qty, SUM(w.warehouse_base_qty * d.rate) AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM receives p
                    LEFT JOIN receive_details d ON p.id = d.receive_id
                    LEFT JOIN receive_by_warehouses w on w.receive_id = p.id and d.product_id = w.product_id
                    WHERE p.receive_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , w.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, SUM(d.quantity) AS pur_ret_qty, SUM(d.quantity * d.rate) AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM purchase_receive_returns p
                    LEFT JOIN purchase_receive_return_details d ON p.id = d.return_id
                    WHERE p.receive_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, SUM(d.quantity) sale_ret_Qty, SUM(d.quantity * d.rate) AS sale_ret_Amount, 0 wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM sale_returns p
                    LEFT JOIN sale_return_details d ON p.id = d.return_id
                    WHERE p.sale_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id ,0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, SUM(d.quantity) wastage_ret_qty, SUM(d.quantity * d.rate) AS wastage_ret_Amount, 0 adjustment_qty, 0 transfer_qty
                    FROM wastages p
                    LEFT JOIN wastage_details d ON p.id = d.wastage_id
                    WHERE p.wastage_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.warehouse_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 AS wastage_ret_qty, 0 AS wastage_ret_Amount, SUM(d.quantity) adjustment_qty, 0 transfer_qty
                    FROM adjustments p
                    LEFT JOIN adjustment_details d ON p.id = d.adjustment_id
                    WHERE p.adjustment_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , d.warehouse_id
                    UNION ALL
                    SELECT d.product_id, d.from_warehouse_id as warehouse_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 AS rece_qty, 0 AS rece_Amount, 0 AS pur_ret_qty, 0 AS pur_ret_Amount, 0 sale_ret_Qty, 0 AS sale_ret_Amount, 0 AS wastage_ret_qty, 0 AS wastage_ret_Amount, 0 adjustment_qty, SUM(d.quantity) transfer_qty
                    FROM transfers p
                    LEFT JOIN transfer_details d ON p.id = d.transfer_id
                    WHERE p.transfer_date BETWEEN '$date' AND '$date'
                    GROUP BY d.product_id , warehouse_id
                    ) t
                GROUP BY t.product_id , t.warehouse_id
            ) s
            ON s.product_id = i.id
            LEFT JOIN warehouses w ON w.id = s.warehouse_id
            WHERE w.id  = '$warehouse_id' and i.id = '$product_id';"
        );

        $stockNum = $stock ? ($stock[0]?->Open_Qty + $stock[0]?->rece_qty + $stock[0]?->sale_ret_Qty) - ($stock[0]?->pur_ret_qty + $stock[0]?->wastage_ret_qty + $stock[0]?->delivered_qty + $stock[0]?->transfer_qty) : 0;
        return $stockNum;
    }

}