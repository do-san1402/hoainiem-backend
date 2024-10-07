<?php

namespace Modules\News\DataTables;

use App\Models\BreakingNews;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BreakingNewsDataTable extends DataTable
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
            ->editColumn('title', function ($row) {

                if ($row->title) {
                    return json_decode($row->title)->news_title ?? null;
                }

                return null;
            })
            ->editColumn('time_stamp', function ($row) {

                if ($row->time_stamp) {
                    return date("d M Y", $row->time_stamp);
                }

                return null;
            })

            ->addColumn('action', function ($row) {

                $button = '';

                if (auth()->user()->can('update_breaking_news')) {
                    $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-breaking-news-button" title="' . localize("Edit") . '" data-action="' . route('news.breaking-news.update', ['breaking_news' => $row->id]) . '" data-route="' . route('news.breaking-news.edit', ['breaking_news' => $row->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_breaking_news')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm mt-sm-1 mt-lg-0 delete-button" data-bs-toggle="tooltip" title="' . localize("delete") . '" data-action="' . route('news.breaking-news.destroy', ['breaking_news' => $row->id]) . '" ><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BreakingNews $model)
    {
        return $model->newQuery()
            ->where(function ($query) {
            })
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
            ->setTableId('breaking-news-table')
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

            Column::make('title')->title(localize('breaking_news')),
            Column::make('time_stamp')->title(localize('post_time')),
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
        return 'Breaking_News_' . date('YmdHis');
    }

}
