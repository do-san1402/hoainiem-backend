<?php

namespace Modules\News\DataTables;

use App\Models\NewsMst;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\PhotoPost;

class NewsPostDataTable extends DataTable
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
            ->addColumn('category_name', function ($row) {

                if ($row->category) {
                    return '<span class="badge bg-success mr-1">' . ucwords($row->postCategory->category_name ?? null) . '</span>';
                }

                return null;
            })
            ->editColumn('title', function ($row) {
                return htmlspecialchars_decode($row->title);
            })
            ->addColumn('post_by_user_name', function ($row) {

                if ($row->postByUser) {
                    return $row->postByUser->full_name ?? null;
                }

                return null;
            })

            ->addColumn('action', function ($row) {
                $button = '';

                if (auth()->user()->can('update_post')) {
                    $button .= '<a href="' . route('news.post.edit', ['post' => $row->id]) . '" class="btn btn-success-soft btn-sm me-1" data-bs-toggle="tooltip" title="' . localize("update") . '" ><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_post')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm mt-sm-1 mt-lg-0 delete-button" data-bs-toggle="tooltip" title="' . localize("delete") . '" data-action="' . route('news.post.destroy', ['post' => $row->id]) . '" ><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['category_name', 'action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PhotoPost $model)
    {
        return $model->newQuery()
            ->with('postCategory', 'postByUser')
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
            ->setTableId('news-table')
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

            Column::make('title')->title(localize('title')),
            Column::make('category_name')->title(localize('category')),
            Column::make('post_by_user_name')->title(localize('post_by')),
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
        return 'News_' . date('YmdHis');
    }

}
