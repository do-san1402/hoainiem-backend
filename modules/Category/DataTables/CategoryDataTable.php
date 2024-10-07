<?php

namespace Modules\Category\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Category\Entities\Category;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
                return $row->category_name ?? '';
            })

            ->editColumn('slug', function ($row) {
                return $row->slug ?? '';
            })

            ->addColumn('category_image', function ($row) {
                $category_image = '';
                $image = $row->category_imgae != NULL ? asset('storage/' . $row->category_imgae) : asset('backend/assets/dist/img/signature_signature.jpg');
                $category_image .= '<img src="'.$image.'" alt="Category Image" width="20%" style="border: 1px solid #e1e9f1;">';

                if ($row->img_status == 1){
                    $category_image .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger img-status-change"
                        data-bs-toggle="tooltip" title="Update"
                        data-route="'.route('category.save_category_img_status', $row->uuid).'"
                        data-csrf="'.csrf_token().'"><i class="hvr-buzz-out far fa-times-circle"></i>
                    </a>';

                }else{
                    $category_image .= '<a href="javascript:void(0)" class="btn btn-sm btn-success img-status-change"
                        data-bs-toggle="tooltip" title="Update"
                        data-route="'.route('category.save_category_img_status', $row->uuid).'"
                        data-csrf="'.csrf_token().'">
                        <i class="hvr-buzz-out far fa-check-circle"></i>
                    </a>';
                }

                return $category_image;
            })

            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('update_category')) {
                    $button .= '<button onclick="editCategoryDetails(' . $row->id . ')" class="btn btn-success-soft btn-sm me-1" ><i class="fas fa-edit"></i></button>';
                }

                if (auth()->user()->can('delete_category')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm-data-table mt-sm-1 mt-lg-0" data-bs-toggle="tooltip" title="Delete" data-route="' . route('category.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['category_image','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
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

            Column::make('category_name')
                ->title(localize('category_name')),

            Column::make('slug')
                ->title(localize('slug')),

            Column::make('category_image')
                ->title(localize('category_image')),

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
        return 'Category_' . date('YmdHis');
    }
}
