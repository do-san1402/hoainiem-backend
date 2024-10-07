<?php

namespace Modules\News\DataTables;

use App\Models\NewsMst;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
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
                    return '<span class="badge bg-success mr-1">' . ucwords($row->category->category_name ?? null) . '</span>';
                }

                return null;
            })
            ->editColumn('title', function ($row) {
                return htmlspecialchars_decode($row->title);
            })
            ->editColumn('status', function ($row) {
                $html      = '';
                $className = "";

                if (auth()->user()->can('update_news')) {
                    $className = "update-status-button";
                }

                if ($row->status == 1) {
                    $html .= '<span class="btn btn-labeled btn-success mb-2 mr-1 '.$className.'" title="' . localize('publish') . '" data-action="' . route('news.update-status', ['news' => $row->id]) . '" data-update_status="0" >' . localize('publish') . '</span>';
                } else {
                    $html .= '<span class="btn btn-labeled btn-warning mb-2 mr-1 '.$className.'" title="' . localize('unpublish') . '" data-action="' . route('news.update-status', ['news' => $row->id]) . '" data-update_status="1" >' . localize('unpublish') . '</span>';
                }

                return $html;
            })

            ->editColumn('publish_date', function ($row) {

                if ($row->publish_date) {
                    return $row->publish_date->format('Y-m-d');
                }

                return null;
            })
            ->editColumn('post_date', function ($row) {

                if ($row->post_date) {
                    return $row->post_date->format('Y-m-d');
                }

                return null;
            })
            ->addColumn('news_image_path', function ($row) {

                if ($row->photoLibrary) {
                    return '<img src="' . ($row->photoLibrary->image_base_url ?? null) . '" style="height:60; width:100px">';
                }

                return null;
            })
            ->addColumn('post_by_user_name', function ($row) {

                if ($row->reporterBy) {
                    return $row->reporterBy->name ?? null;
                }

                return null;
            })

            ->addColumn('action', function ($row) {
                $button = '';

                if (auth()->user()->can('update_news')) {
                    $button .= '<a href="' . route('news.edit', ['news' => $row->id]) . '" class="btn btn-success-soft btn-sm me-1" data-bs-toggle="tooltip" title="' . localize("update") . '" ><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_news')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm mt-sm-1 mt-lg-0 delete-button" data-bs-toggle="tooltip" title="' . localize("delete") . '" data-action="' . route('news.destroy', ['news' => $row->id]) . '" ><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['category_name', 'news_image_path', 'action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NewsMst $model)
    {
        return $model->newQuery()
            ->with('category', 'postByUser', 'photoLibrary', 'reporterBy')
            ->where(function ($query) {

                if (auth()->user()->user_type_id == 2) {
                    $query->where('reporter_id', auth()->user()->reporter->id ?? null);
                }

                if (!empty($this->request()->input('from_date'))) {
                    $query->where('publish_date', '>=', $this->request()->input('from_date'));
                }

                if (!empty($this->request()->input('to_date'))) {
                    $query->where('publish_date', '<=', $this->request()->input('to_date'));
                }

                if (!empty($this->request()->input('other_page'))) {
                    $query->where('page', '=', $this->request()->input('other_page'));
                }

                if (!empty($this->request()->input('title'))) {
                    $query->where('title', 'LIKE', '%' . $this->request()->input('title') . '%');
                }

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

            Column::make('news_image_path')->title(localize('image')),
            Column::make('title')->title(localize('title')),
            Column::make('category_name')->title(localize('category')),
            Column::make('reader_hit')->title(localize('hit')),
            Column::make('post_by_user_name')->title(localize('post_by')),
            Column::make('publish_date')->title(localize('release_date')),
            Column::make('post_date')->title(localize('post_date')),
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
        return 'News_' . date('YmdHis');
    }

}
