<?php

namespace Modules\UserManagement\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\UserManagement\Entities\PerMenu;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MenuListDataTable extends DataTable
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
            ->addColumn('parent_menu_name', function ($data) {
                return empty(parentMenu($data->parentmenu_id)) ? "" : localize('' . parentMenu($data->parentmenu_id));
            })

            ->addColumn('action', function ($data) {

                $button = '';
                $button .= '<button onclick="detailsView(' . $data->id . ')" id="detailsView-' . $data->id . '" data-url="' . route('role.menu.edit', $data->id) . '" class="btn btn-success-soft btn-sm me-1" ><i class="fa fa-edit"></i></button>';

                $button .= '<button onclick="deleteMenu(' . $data->id . ')" id="deleteMenu' . $data->id . '"  data-menu_delete_url="' . route('role.menu.delete') . '" class="btn btn-danger-soft btn-sm me-1"><i class="fa fa-trash"></i></button>';
                return $button;

            })

            ->rawColumns(['parent_menu_name', 'status', 'action']);

    }

    /**
     * Get query source of dataTable.
     */
    public function query(PerMenu $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', orderByData($this->request->get('order')));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menu-table')
            ->setTableAttribute('class', 'table table-hover table-bordered align-middle')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                //change preloader icon
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->selectStyleSingle()
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']])
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
                ->width(10)
                ->title(localize('sl'))
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('menu_name')
                ->title(localize('menu_name'))
                ->searchable(true),
            Column::make('parent_menu_name')
                ->title(localize('parent_menu'))
                ->searchable(true),
            Column::make('lable')
                ->title(localize('label'))
                ->searchable(true),
            Column::make('action')
                ->width(80)
                ->title(localize('action'))
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
        return 'roles-' . date('YmdHis');
    }
}
