<?php

namespace Modules\Setting\Http\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Setting\Entities\ActivityLog;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
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

            ->addColumn('checkbox', function ($product) {
                return '<input type="checkbox" class="checkbox" onclick="singleProductSelect()" data-id="' . $product->id . '">';
            })

            ->editColumn('created_at', function ($row) {
                $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
                return $dateTime;
            })
            ->addColumn('done_by', function ($row) {
                return $row->user?->full_name;
            })

            ->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm" data-bs-toggle="tooltip" title="Delete" data-route="' . route('activity_log_destroy', $row->id) . '" data-csrf="' . csrf_token() . '" data-table="activity-log-table"><i class="fas fa-trash-alt"></i></a>';
            })

            ->rawColumns(['checkbox', 'done_by', 'action']);

    }

    /**
     * Get query source of dataTable.
     */

    public function query(ActivityLog $model): QueryBuilder
    {
        $user_name = $this->request->get('user_name');
        $log_date = $this->request->get('log_date');

        return $model->newQuery()->with('user')
            ->when($user_name, function ($query) use ($user_name) {
                return $query->whereHas('user', function ($query) use ($user_name) {
                    $query->where('id', $user_name);
                });
            })
            ->when($log_date, function ($query) use ($log_date) {
                $string = explode('-', $log_date);
                if ($log_date) {
                    $fromDate = date('Y-m-d 00:00:00', strtotime($string[0]));
                    $toDate = date('Y-m-d 23:59:59', strtotime($string[1]));
                } else {
                    $fromDate = '';
                    $toDate = '';
                }
                return $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('activity-log-table')
            ->setTableAttribute('class', 'table table-hover table-bordered align-middle')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                //change preloader icon
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->selectStyleSingle()
            ->lengthMenu([[10, 25, 50, 100], [10, 25, 50, 100]])
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

            Column::computed('checkbox')
                ->title('<input type="checkbox" id="check_all" onclick="selectAll()"> '.localize('all'))
                ->addClass('text-center')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(40),

            Column::make('created_at')
                ->title(localize('date'))
                ->searchable(true),

            Column::make('log_name')
                ->title(localize('log_name'))
                ->searchable(true),

            Column::make('description')
                ->title(localize('description'))
                ->searchable(true),

            Column::make('done_by')
                ->title(localize('done_by'))
                ->searchable(true),

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
