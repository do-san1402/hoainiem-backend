<?php

namespace App\DataTables;

use App\Models\PhotoLibrary;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PhotoLibraryDataTable extends DataTable
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
            ->addColumn('image_path', function ($row) {

                if ($row->thumb_image) {
                    $image_path = !$row->disk || $row->disk == 'local' ? storage_asset_image($row->thumb_image) : $row->thumb_image;
                    return '<img src="' . $image_path . '" style="height:60px; width:100px;">';
                }

                return null;
            })
            ->addColumn('action', function ($row) {
                $button = '';

                if (auth()->user()->can('delete_media_library')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm mt-sm-1 mt-lg-0 delete-button" data-bs-toggle="tooltip" title="' . localize("delete") . '" data-action="' . route('photo-library.destroy', ['photo_library' => $row->id]) . '" ><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })
            ->editColumn('image_base_url', function ($row) {

                if ($row->image_base_url) {
                    return '<input type="text" value="' . $row->image_base_url . '" readonly="">';
                }

                return null;
            })
            ->rawColumns(['category_name', 'image_path', 'action', 'image_base_url']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PhotoLibrary $model)
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
            ->setTableId('category-table')
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

            Column::make('image_path')->title(localize('image')),
            Column::make('picture_name')->title(localize('image_name')),
            Column::make('title')->title(localize('title')),
            Column::make('category')->title(localize('category')),
            Column::make('image_base_url')->title(localize('image_url')),
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
        return 'Photo_Library_' . date('YmdHis');
    }

}
