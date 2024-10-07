<?php

namespace Modules\Archive\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Archive\Entities\MaxArchiveSetting;
use Modules\Category\Entities\Category;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Modules\Setting\Entities\Setting;
use Illuminate\Support\Facades\DB;

class ArchiveDataTable extends DataTable
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

            ->editColumn('category_name', function ($row) {
                return $row->category_name;
            })

            ->editColumn('maximum_news', function ($row) {

                return '<input type="hidden" class="form-control" name="category_ids[]" value="' . htmlspecialchars($row->category_id) . '">'.
                       '<input type="number" class="form-control" name="max_archives[]" value="' . (($row->max_archive == '') ? 0 : $row->max_archive) . '">';

            })

            ->editColumn('available_for_archive', function ($row) {
                
                $btnClass = htmlspecialchars($row->available_for_archive) > 0 ? "success" : "warning";
                $displayValue = htmlspecialchars($row->available_for_archive) <= 0 ? 0 : htmlspecialchars($row->available_for_archive);
                
                return '<div class="btn btn-' . $btnClass . '">' . $displayValue . '</div>';
                
            })

            ->editColumn('action', function ($row) {
                
                $button = '';

                $btnClass = htmlspecialchars($row->available_for_archive) <= 0 ? 'disabled' : '';
                $modalTarget = htmlspecialchars($row->available_for_archive) <= 0 ? 'disabled' : '#myModal';
                $id = htmlspecialchars($row->category_id) . '~' . $row->available_for_archive;

                if (auth()->user()->can('update_archive_setting')) {

                    $button .= '<button type="button" class="btn btn-primary archive_modal ' . $btnClass . ' me-2" id="' . $id . '" onclick="archiveCreate('.htmlspecialchars($row->category_id).','.$row->available_for_archive.')">' . localize('archive') . '</button>';
                }

                $categoryId = htmlspecialchars($row->category_id);
                $displayText = htmlspecialchars(localize('delete'));

                if (auth()->user()->can('delete_archive_setting')) {

                    $button .= '<button type="button" class="btn btn-danger delete-confirm-data-table" data-bs-toggle="tooltip" title="Delete" data-route="' . route('archive.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '">' . $displayText . '</button>';
                
                }

                return $button;
            })

            ->rawColumns(['maximum_news','available_for_archive','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        // Build the query using Eloquent query builder and inner join
        $query = $model->newQuery()
        ->select('max_archive_settings.uuid', 'categories.category_id', 'categories.slug', 'categories.category_name', 'max_archive_settings.max_archive')
        ->join('max_archive_settings', 'max_archive_settings.category_id', '=', 'categories.category_id')
        ->selectRaw('COALESCE((
                        SELECT COUNT(*)
                        FROM news_msts
                        WHERE page = REPLACE(categories.slug, "\'", "")
                    ), 0) - COALESCE(max_archive_settings.max_archive, 0) AS available_for_archive')
        ->where('max_archive_settings.deleted_at', Null);
        
        // dd($query);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('archive-table')
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
                    ->text('<i class="fa fa-file-csv"></i> CSV')->exportOptions(['columns' => [0, 1]]),
                Button::make('excel')
                    ->className('btn btn-secondary buttons-excel buttons-html5 btn-sm prints')
                    ->text('<i class="fa fa-file-excel"></i> Excel')
                    ->extend('excelHtml5')->exportOptions(['columns' => [0, 1]]),
            ])
            ->parameters([
                'paging' => false, // Disable pagination
                'searching' => true, // Disable searching if you want to show all data without filtering
                'lengthChange' => false, // Disable length change
                'info' => false, // Disable the "Showing X to Y of Z entries" info
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
                ->width(100)
                ->searchable(false)
                ->orderable(false),

            Column::make('category_name')
                ->title(localize('category'))
                ->width(300),

            Column::make('maximum_news')
                ->title(localize('maximum_news'))
                ->searchable(false)
                ->orderable(false)
                ->width(300),

            Column::make('available_for_archive')
                ->searchable(false)
                ->orderable(false)
                ->title(localize('available_for_archive')),

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
        return 'Archive_' . date('YmdHis');
    }
}
