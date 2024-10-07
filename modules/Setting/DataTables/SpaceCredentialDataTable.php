<?php

namespace Modules\Setting\DataTables;

use App\Models\SpaceCredential;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SpaceCredentialDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                $button = '';

                if (auth()->user()->can('update_space_credential')) {
                    $button .= '<a href="javascript:void(0);" data-action="' . route('space-credential.update', ['space_credential' => $row->id]) . '" data-route="' . route('space-credential.edit', ['space_credential' => $row->id]) . '" class="btn btn-success-soft btn-sm me-1 edit-space-credential" data-bs-toggle="tooltip" title="' . localize("update") . '" ><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_space_credential')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm mt-sm-1 mt-lg-0 delete-button" data-bs-toggle="tooltip" title="' . localize("delete") . '" data-action="' . route('space-credential.destroy', ['space_credential' => $row->id]) . '" ><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })
            ->editColumn('status', function ($row) {
                $html      = '';
                $className = "";

                if (auth()->user()->can('update_mail_setup')) {
                    $className = "update-status-button";
                }

                if ($row->status == 1) {
                    $html .= '<span class="btn btn-labeled btn-success mb-2 mr-1  '.$className.'" title="' . localize('publish') . '" data-action="' . route('space-credential.update-status', ['space_credential' => $row->id]) . '" data-update_status="0" >' . localize('publish') . '</span>';
                } else {
                    $html .= '<span class="btn btn-labeled btn-warning mb-2 mr-1  '.$className.'" title="' . localize('unpublish') . '" data-action="' . route('space-credential.update-status', ['space_credential' => $row->id]) . '" data-update_status="1" >' . localize('unpublish') . '</span>';
                }

                return $html;
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param SpaceCredential $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SpaceCredential $model)
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
            ->setTableId('space-credential-table')
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
                    ->text('<i class="fa fa-file-csv"></i> CSV')->exportOptions(['columns' => [0, 1, 2]]),
                Button::make('excel')
                    ->className('btn btn-secondary buttons-excel buttons-html5 btn-sm prints')
                    ->text('<i class="fa fa-file-excel"></i> Excel')
                    ->extend('excelHtml5')->exportOptions(['columns' => [0, 1, 2]]),
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

            Column::make('key')->title(localize('key')),
            Column::make('secret')->title(localize('secret')),
            Column::make('region')->title(localize('region')),
            Column::make('bucket')->title(localize('bucket')),
            Column::make('url')->title(localize('url')),
            Column::make('status')->title(localize('status')),
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
        return 'Space_Credential_' . date('YmdHis');
    }

}
