<?php

namespace App\DataTables;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FacilityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $btnEdit = '<a href="' . route('admin.facility.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('admin.facility.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnEdit . $btnDelete;
            })
            ->addColumn('icon', function ($query) {
                return '<i class="' . $query->icon . '" style="font-size:30px"></i>';
            })
            ->addColumn('status', function ($query) {
                if ($query->status !== 1) {
                    return "<span class='badge badge-secondary'>Hide</span>";
                } else {
                    return "<span class='badge badge-success'>Active</span>";
                }
            })
            ->rawColumns(['icon', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Facility $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('facility-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(100),
            Column::make('name'),
            Column::make('slug'),
            Column::make('icon'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Facility_' . date('YmdHis');
    }
}
