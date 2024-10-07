<?php

namespace Modules\Setting\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Setting\Entities\Zkt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ZktDataTable extends DataTable
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
            ->editColumn('chain_type', function ($model) {
                return ucwords($model->chain_type);
            })
            ->addColumn('status', function ($model) {

                $status = '';

                if ($model->status == 1) {
                    $status .= '<span class="badge badge-success-soft sale-badge-ft-13">' . localize('active') . '</span>';
                } else {
                    $status .= '<span class="badge badge-danger-soft sale-badge-ft-13">' . localize('inactive') . '</span>';
                }

                return $status;
            })
            ->addColumn('action', function ($model) {

                $button = '';
                $button .= '<button onclick="editZkt(' . $model->id . ')" id="editZkt-' . $model->id . '" data-edit_url="' . route('zktSetup.edit', $model->id) . '" data-update_url="' . route('zktSetup.update', $model->id) . '" class="btn btn-success-soft btn-sm me-1" ><i class="fas fa-edit"></i></button>';

                $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm" data-bs-toggle="tooltip" title="Delete" data-route="' . route('zktSetup.destroy', $model->id) . '" data-csrf="' . csrf_token() . '" data-table="zkt-table" ><i class="fas fa-trash-alt"></i></a>';

                return $button;
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */

    public function query(Zkt $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('zkt-table')
            ->setTableAttribute('class', 'table table-hover table-bordered align-middle')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                //change preloader icon
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->selectStyleSingle()
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']])
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

            Column::make('DT_RowIndex')
                ->title('SL.')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),

            Column::make('device_id')
                ->title(localize('device_id'))
                ->searchable(true),

            Column::make('ip_address')
                ->title(localize('ip_address'))
                ->searchable(true),

            Column::make('status')
                ->title(localize('status')),

            Column::make('action')
                ->title('Action')
                ->searchable(false)
                ->printable(false)
                ->exportable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ModelChainType-' . date('YmdHis');
    }
}
