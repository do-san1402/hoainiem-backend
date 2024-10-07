<?php

namespace Modules\Reporter\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Reporter\Entities\Reporter;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReporterDataTable extends DataTable
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

            ->editColumn('photo', function ($row) {
                $reporter_image = '';
                $image = $row->photo != NULL ? asset('storage/' . $row->photo) : asset('backend/assets/dist/img/signature_signature.jpg');
                $reporter_image .= '<img src="'.$image.'" alt="Reporter Image" width="80%" style="border: 1px solid #e1e9f1;">';
                return $reporter_image;
            })

            ->editColumn('name', function ($row) {
                return $row->name ?? '';
            })

            ->addColumn('status', function ($row) {

                $status = '';

                if (auth()->user()->can('update_reporter')) {

                    if ($row->status == 1){
                        $status .= '<a href="javascript:void(0)" class="btn btn-sm btn-success reporter-status-change"
                            data-bs-toggle="tooltip" title="Update"
                            data-route="'.route('reporter.reporter_status_edit', $row->uuid).'"
                            data-csrf="'.csrf_token().'"><i class="hvr-buzz-out far fa-check-circle"></i>
                        </a>';

                    }else{
                        $status .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger reporter-status-change"
                            data-bs-toggle="tooltip" title="Update"
                            data-route="'.route('reporter.reporter_status_edit', $row->uuid).'"
                            data-csrf="'.csrf_token().'"><i class="hvr-buzz-out far fa-times-circle"></i>
                        </a>';
                    }

                }

                return $status;
            })

            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('update_reporter')) {
                    $button .= '<button onclick="editReporterDetails(' . $row->id . ')" class="btn btn-success-soft btn-sm me-1" ><i class="fas fa-edit"></i></button>';
                }

                if (auth()->user()->can('delete_reporter')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm-data-table mt-sm-1 mt-lg-0" data-bs-toggle="tooltip" title="Delete" data-route="' . route('reporter.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['photo','status','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reporter $model)
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
            ->setTableId('reporter-table')
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
                    ->text('<i class="fa fa-file-csv"></i> CSV')->exportOptions(['columns' => [0, 2, 3, 4]]),
                Button::make('excel')
                    ->className('btn btn-secondary buttons-excel buttons-html5 btn-sm prints')
                    ->text('<i class="fa fa-file-excel"></i> Excel')
                    ->extend('excelHtml5')->exportOptions(['columns' => [0, 2, 3, 4]]),
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

            Column::make('photo')
                ->title(localize('picture'))
                ->width(100),

            Column::make('name')
                ->title(localize('full_name')),

            Column::make('mobile')
                ->title(localize('mobile')),
            
            Column::make('address_one')
                ->title(localize('address')),
            
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
        return 'Reporter_' . date('YmdHis');
    }
}
