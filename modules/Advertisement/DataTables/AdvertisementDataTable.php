<?php

namespace Modules\Advertisement\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Advertisement\Entities\Advertisement;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Modules\Setting\Entities\Setting;

class AdvertisementDataTable extends DataTable
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
            ->addColumn('ad_position', function ($row) {
                $page = '';
                if ($row->page == 1){
                    $page = "Home Page ". $row->ad_position;
                }elseif ($row->page == 2){
                    $page = "Category Page ". $row->ad_position;
                }else{
                    $page = "View Page ". $row->ad_position;
                }

                return $page ?? '';
            })

            ->editColumn('embed_code', function ($row) {
                return $row->embed_code ?? '';
            })

            ->addColumn('large_status', function ($row) {

                if (auth()->user()->can('update_advertise')) {
                    $largeStatusClass = $row->large_status == 0 ? 'danger' : 'success';
                    $largeStatusText = $row->large_status == 0 ? 'OFF' : 'ON';

                    $large_status = '<a href="javascript:void(0)" class="btn btn-' . $largeStatusClass . '-soft btn-sm me-1 update-lg-status"
                        data-bs-toggle="tooltip" title="'.localize('update_status').'"
                        data-route="'.route('advertise.update_lg_status', $row->uuid).'"
                        data-csrf="'.csrf_token().'">' . $largeStatusText . '</i>';

                    return $large_status;
                }
            })

            ->addColumn('mobile_status', function ($row) {

                if (auth()->user()->can('update_advertise')) {
                    $statusClass = $row->mobile_status == 0 ? 'danger' : 'success';
                    $statusText = $row->mobile_status == 0 ? 'OFF' : 'ON';

                    $mobile_status = '<a href="javascript:void(0)" class="btn btn-' . $statusClass . '-soft btn-sm me-1 update-sm-status"
                        data-bs-toggle="tooltip" title="'.localize('update_status').'"
                        data-route="'.route('advertise.update_sm_status', $row->uuid).'"
                        data-csrf="'.csrf_token().'">' . $statusText . '</i>';

                    return $mobile_status;
                }
            })

            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('update_advertise')) {
                    $button .= '<button onclick="editAdvDetails(' . $row->id . ', ' . $row->page . ', ' . $row->ad_position . ')" class="btn btn-success-soft btn-sm me-1" ><i class="fas fa-edit"></i></button>';
                }

                if (auth()->user()->can('delete_advertise')) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm-data-table mt-sm-1 mt-lg-0" data-bs-toggle="tooltip" title="Delete" data-route="' . route('advertise.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return $button;
            })

            ->rawColumns(['embed_code', 'ad_position','large_status','mobile_status','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Advertisement $model)
    {
        $ac = Setting::select('details')->where('id', 16)->first();
        $ac = json_decode($ac->details);

        return $model->newQuery()
            ->where('theme', $ac->default_theme)
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
            ->setTableId('advertise-table')
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

            Column::make('ad_position')
                ->title(localize('ads_position')),

            Column::make('embed_code')
                ->title(localize('embed_code'))
                ->width(100),

            Column::make('large_status')
                ->title(localize('desktop_or_tablet')),

            Column::make('mobile_status')
                ->title(localize('mobile')),

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
        return 'Advertisement_' . date('YmdHis');
    }
}
