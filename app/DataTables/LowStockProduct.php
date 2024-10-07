<?php

namespace App\DataTables;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LowStockProduct extends DataTable
{
    public function dataTable(): CollectionDataTable
    {
        $query = (new CollectionDataTable($this->collection()))->addIndexColumn();
        return $query->editColumn('product_name', function ($data) {
            $productModel = $data->product_model ? ' (' . $data->product_model . ')' : '';
            return $data->product_name . $productModel;
        });
    }

    public function collection()
    {

        $from_date = $this->request->get('from_date');
        if ($from_date && $from_date != 'null' && $from_date != 'undefined' && $from_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date));

        } else {
            $from_date = Carbon::now()->format('Y-m-d');
        }

        $to_date = $this->request->get('to_date');
        if ($to_date && $to_date != 'null' && $to_date != 'undefined' && $to_date != '') {
            $to_date = date('Y-m-d', strtotime($to_date));

        } else {
            $to_date = Carbon::now()->format('Y-m-d');
        }

        $data = DB::select(
            "Select id,  product_name, product_model,category_name, created_at, price, cost , category_id,
            SUM(Open_Qty) Open_Qty
            ,SUM(rece_qty) rece_qty
            ,SUM(sale_ret_Qty) sale_ret_Qty
            ,SUM(pur_ret_qty) pur_ret_qty
            ,SUM(wastage_ret_qty) wastage_ret_qty
            , SUM(delivered_qty) delivered_qty
            ,(SUM(Open_Qty) + SUM(rece_qty) + SUM(sale_ret_Qty)) - (SUM(pur_ret_qty) + SUM(wastage_ret_qty)) - SUM(delivered_qty) as stock, minimum_qty_alert
            From (

            Select i.id,  i.product_name, i.product_model, i.price, i.cost,i.category_id,c.category_name as category_name, Open_Qty, delivered_qty, delivered_Amount, rece_qty, rece_Amount, i.created_at as created_at, pur_ret_qty, pur_ret_Amount, sale_ret_Qty, sale_ret_Amount, wastage_ret_qty, wastage_ret_Amount , minimum_qty_alert
            From

            product_information i
            left join categories c on i.category_id = c.id
            left join (

            select t.product_id,
            sum(open_Qty) Open_Qty,
            sum(delivered_qty) delivered_qty,sum(delivered_Amount) delivered_Amount, sum(rece_qty) rece_qty, sum(rece_Amount) rece_Amount,sum(pur_ret_qty) as pur_ret_qty, sum(pur_ret_Amount) as pur_ret_Amount,sum(sale_ret_Qty) sale_ret_Qty, sum(sale_ret_Amount) as sale_ret_Amount, sum(wastage_ret_qty) wastage_ret_qty, sum(wastage_ret_Amount) as wastage_ret_Amount
            from (

            SELECT d.product_id, sum(d.quantity) Open_Qty, 0 as delivered_qty, sum(d.quantity*d.price) as delivered_Amount, 0 rece_qty, 0 as rece_Amount, 0 pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM delivery_items p
                left join delivery_item_details d on p.id = d.delivery_id
                where p.delivery_date < ?

                Group by d.product_id

                union all
                SELECT d.product_id, sum(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount ,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount

                FROM receives p
                left join receive_details d on p.id = d.receive_id
                where p.receive_date < ?

                Group by d.product_id

                union all
                SELECT d.product_id, sum(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM purchase_receive_returns p
                left join purchase_receive_return_details d on p.id = d.return_id
                where p.receive_date < ?

                Group by d.product_id

                union all
                SELECT d.product_id, sum(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM sale_returns p
                left join sale_return_details d on p.id = d.return_id
                where p.sale_date < ?

                Group by d.product_id


                union all
                SELECT d.product_id, sum(d.quantity) Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM wastages p
                left join wastage_details d on p.id = d.wastage_id
                where p.wastage_date < ?

                Group by d.product_id


                Union all
                SELECT d.product_id, 0 Open_Qty, sum(d.quantity) as delivered_qty, sum(d.quantity*d.price) as delivered_Amount, 0 rece_qty, 0 as rece_Amount, 0 pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM delivery_items p
                left join delivery_item_details d on p.id = d.delivery_id
                where p.delivery_date between ? and ?

                Group by d.product_id

                union all
                SELECT d.product_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, sum(d.quantity) rece_qty, sum(d.quantity*d.rate) as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM receives p
                left join receive_details d on p.id = d.receive_id
                where p.receive_date between ? and ?

                Group by d.product_id

                union all
                SELECT d.product_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, sum(d.quantity) as pur_ret_qty, sum(d.quantity*d.rate) as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM purchase_receive_returns p
                left join purchase_receive_return_details d on p.id = d.return_id
                where p.receive_date between ? and ?

                Group by d.product_id

                union all
                SELECT d.product_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,sum(d.quantity) sale_ret_Qty, sum(d.quantity*d.rate) as sale_ret_Amount, 0 wastage_ret_qty, 0 as wastage_ret_Amount
                FROM sale_returns p
                left join sale_return_details d on p.id = d.return_id
                where p.sale_date between ? and ?

                Group by d.product_id

                union all
                SELECT d.product_id, 0 Open_Qty, 0 pur_qty, 0 pur_Amount, 0 as rece_qty, 0 as rece_Amount, 0 as pur_ret_qty, 0 as pur_ret_Amount,0 sale_ret_Qty, 0 as sale_ret_Amount, sum(d.quantity) wastage_ret_qty, sum(d.quantity*d.rate) as wastage_ret_Amount
                FROM wastages p
                left join wastage_details d on p.id = d.wastage_id
                where p.wastage_date between ? and ?

                Group by d.product_id


                ) t
                Group by t.product_id
            ) s
            on s.product_id = i.id
            where i.minimum_qty_alert > CAST(Open_Qty AS SIGNED)
            ) a
            group by id
            HAVING stock = 0
            ",
            [$from_date, $from_date, $from_date, $from_date, $from_date, $from_date, $to_date, $from_date, $to_date, $from_date, $to_date, $from_date, $to_date, $from_date, $to_date]
        );

        $data = collect($data);
        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {

        $print_admin_and_time = localize('print_date') . Carbon::now()->format('d-m-Y h:i:sa') . ", User: " . auth()->user()->full_name;
        return $this->builder()
            ->setTableId('low-stock-alert-product-table')
            ->minifiedAjax(route('getLowStockProductList'))
            ->setTableAttribute('class', 'table table-bordered table-hover w-100')
            ->responsive()
            ->language([
                //change preloader icon
                'processing' => '<div class="lds-spinner">
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->columns($this->getColumns())
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']])
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 py-2 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title(localize('sl'))
                ->addClass('text-center column-sl')
                ->searchable(false)
                ->orderable(false),

            Column::make('category_name')
                ->title(localize('category_name')),

            Column::make('product_name')
                ->title(localize('product_name')),

            Column::make('minimum_qty_alert')
                ->title(localize('minimum_qty_alert')),

            Column::make('stock')
                ->title(localize('stock')),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'LowStockProduct-' . date('YmdHis');
    }
//pdf table style
    private function pdfCustomizeTableHeader(): string
    {
        return '
            //row width
            doc.content[5].table.widths[0] = 25;
            doc.content[5].table.widths[1] = 100;
            doc.content[5].table.widths[2] = 300;

            //header colum css
            doc.content[5].table.body[0][0].alignment = \'left\';
            doc.content[5].table.body[0][1].alignment = \'left\';
            doc.content[5].table.body[0][2].alignment = \'left\';


            //change body colum css
            doc.content[5].table.body.forEach(function(row) {
                row[0].alignment = \'left\';
                row[1].alignment = \'left\';
                row[2].alignment = \'left\';
                row[3].alignment = \'right\';
            });

            //change footer css
            doc.content[5].table.body[doc.content[5].table.body.length - 1].forEach(function(cell) {
                cell.color = \'#000\';
            });
        ';
    }

    //pdf export design
    private function pdfDesign(): string
    {
        return '
        //pdf margin
        doc.pageMargins = [15, 5, 15, 10];

        //admin name top of page left
        doc.content.splice(0, 0, {
            //left, top, right, bottom
            margin: [0, 0, 0, 0],
            alignment: \'left\',
            text: [
                { text: \'\', fontSize: 7, bold: false },
                ]
            });


        //pdf header add logo
        doc.content.splice(1, 0, {
            margin: [0, 0, 0, 0],
            alignment: \'center\',
            width: 110,
             image: \'' . logo_64_data() . '\'
        });

        //pdf header add address
        doc.content.splice(2, 0, {
            //left, top, right, bottom
            margin: [0, 0, 0, 10],
            alignment: \'center\',
            text: [
                { text: \'' . app_setting()->address . '\', fontSize: 8, bold: false },
                ]
            });

        //date range
        var date_range = $(\'#stock-report-range\').val();
        if(date_range == \'\'){
            date_range = \'All\';
        }
        doc.content.splice(4, 0, {
            //left, top, right, bottom
            margin: [0, -10, 0, 5],
            alignment: \'right\',
            text: [
                { text: "", fontSize: 8, bold: false },
                ]
            });

        doc.content[5].table.widths = Array(doc.content[5].table.body[0].length + 1).join(\'*\').split(\'\');

        //change table font size && table fill color
        doc.content[5].table.body.forEach(function(row) {
            row.forEach(function(cell) {
                cell.fontSize = 8;
                cell.fillColor = \'#fff\';
            });
        });

        //change header text color
        doc.content[5].table.body[0].forEach(function(cell) {
            cell.color = \'#000\';
        });

        var objLayout = {};
        objLayout[\'hLineWidth\'] = function(i) { return .5; };
        objLayout[\'vLineWidth\'] = function(i) { return .5; };
        objLayout[\'hLineColor\'] = function(i) { return \'#000\'; };
        objLayout[\'vLineColor\'] = function(i) { return \'#000\'; };
        objLayout[\'paddingLeft\'] = function(i) { return 4; };
        objLayout[\'paddingRight\'] = function(i) { return 4; };
        doc.content[5].layout = objLayout;';
    }

}
