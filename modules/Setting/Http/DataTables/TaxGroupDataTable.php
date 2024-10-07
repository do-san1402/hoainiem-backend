<?php

namespace Modules\Setting\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Setting\Entities\TaxSetting;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TaxGroupDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($taxGroup) {
                $button = '';
                $button .= '<button onclick="editTaxGroup(' . $taxGroup->id . ')" id="editTaxGroup' . $taxGroup->id . '"  data-tax_group_edit_url="' . route('sale.tax.group.get') . '" class="btn btn-primary-soft btn-sm me-1"><i class="fa fa-edit"></i></button>';
                $button .= '<button onclick="deleteTaxGroup(' . $taxGroup->id . ')" id="deleteTaxGroup' . $taxGroup->id . '"  data-tax_group_delete_url="' . route('sale.tax.group.delete') . '" class="btn btn-danger-soft btn-sm me-1"><i class="fa fa-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
        ;
    }

    /**
     * Get query source of dataTable.
     */
    public function query(TaxSetting $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('tax_type', 1)
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tax-group-data-table')
            ->setTableAttribute('class', 'table table-bordered table-hover')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                //change preloader icon
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->selectStyleSingle()
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
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
            //addIndexColumn is added here
            Column::make('DT_RowIndex')
                ->title(localize('sl'))
                ->addClass('text-center column-sl')
                ->searchable(false)
                ->orderable(false)
                ->width(10),
            Column::make('tax_name')
                ->title(localize('tax_group_name'))
                ->searchable(true)
                ->addClass('text-right'),
            Column::make('tax_percentage')
                ->title(localize('total_tax_percentage'))
                ->searchable(false)
                ->addClass('text-right'),
            Column::make('action')
                ->title(localize('action'))->addClass('column-sl')->orderable(false)
                ->searchable(false)
                ->addClass('text-start')
                ->width(100),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'TaxGroup_' . date('YmdHis');
    }

}
