<?php

namespace Modules\Page\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Page\Entities\Page;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('publishar_id', function ($row) {
                return $row->publisher_user_info->full_name ?? '';
            })

            ->addColumn('status', function ($row) {

                if (auth()->user()->can('update_page')) {

                    $statusClass = $row->status == 0 ? 'warning' : 'success';
                    $statusText = $row->status == 0 ? 'Publish' : 'Unpublish';

                    $Status = '<a href="javascript:void(0)" class="btn btn-' . $statusClass . ' w-100p mb-2 rounded-pill text-white update-page-status"
                        data-bs-toggle="tooltip" title="'.localize('update_status').'"
                        data-route="'.route('page.update_page_status', $row->uuid).'"
                        data-csrf="'.csrf_token().'">' . $statusText . '</i>';

                    return $Status;
                }
            })

            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('update_page')) {
                    $button .= '<a href="'.route('page.edit', $row->id).'" class="btn btn-success-soft btn-sm me-1" data-bs-toggle="tooltip" title="'.localize('update').'"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_page')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm-data-table mt-sm-1 mt-lg-0" data-bs-toggle="tooltip" title="Delete" data-route="' . route('page.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['status','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model)
    {
        return $model->newQuery()
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('page-table')
            ->setTableAttribute('class', 'table table-hover table-bordered align-middle table-sm')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->responsive(true)
            ->selectStyleSingle()
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']])
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->buttons([
                Button::make('csv')
                    ->className('btn btn-secondary buttons-csv buttons-html5 btn-sm prints')
                    ->text('<i class="fa fa-file-csv"></i> CSV')->exportOptions(['columns' => [0, 1, 2, 3]]),
                Button::make('excel')
                    ->className('btn btn-secondary buttons-excel buttons-html5 btn-sm prints')
                    ->text('<i class="fa fa-file-excel"></i> Excel')
                    ->extend('excelHtml5')->exportOptions(['columns' => [0, 1, 2, 3]]),
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [

            Column::make('DT_RowIndex')
                ->title(localize('sl'))
                ->addClass('text-center column-sl')
                ->width(50)
                ->searchable(false)
                ->orderable(false),

            Column::make('title')
                ->title(localize('title')),

            Column::make('publishar_id')
                ->title(localize('writer')),

            Column::make('publish_date')
                ->title(localize('date')),

            Column::make('status')
                ->title(localize('status')),

            Column::make('action')
                ->title(localize('action'))->addClass('column-sl')->orderable(false)
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
        return 'Page_' . date('YmdHis');
    }
}
