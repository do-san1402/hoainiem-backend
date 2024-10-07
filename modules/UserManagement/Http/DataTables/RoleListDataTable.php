<?php

namespace Modules\UserManagement\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleListDataTable extends DataTable
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

            ->addColumn('action', function ($data) {

                $button = '';
                $button .= '<a href="' . route('role.edit', $data->id) . '" class="btn btn-primary-soft btn-sm me-1"  title="Edit"><i class="fa fa-edit"></i></a>';
                if ($data->id != 1) {
                    $button .= '<button onclick="deleteRole(' . $data->id . ')" id="deleteRole' . $data->id . '"  data-role_delete_url="' . route('role.delete') . '" class="btn btn-danger-soft btn-sm me-1"><i class="fa fa-trash"></i></button>';
                }
                return $button;

            })

            ->rawColumns(['status', 'action']);

    }

    /**
     * Get query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('role-table')
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
            Column::make('name')
                ->title(localize('name'))
                ->searchable(true),
            Column::make('action')
                ->width(70)
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
