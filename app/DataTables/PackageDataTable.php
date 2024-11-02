<?php

namespace App\DataTables;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PackageDataTable extends DataTable
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
                $btnEdit = '<a href="' . route('admin.packages.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('admin.packages.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnEdit . $btnDelete;
            })
            ->addColumn('display_at_home', function ($query) {
                if ($query->display_at_home !== 1) {
                    return "<span class='badge badge-secondary'>No</span>";
                } else {
                    return "<span class='badge badge-success'>Yes</span>";
                }
            })
            ->addColumn('status', function ($query) {
                if ($query->status !== 1) {
                    return "<span class='badge badge-secondary'>Hide</span>";
                } else {
                    return "<span class='badge badge-success'>Active</span>";
                }
            })
            ->rawColumns(['display_at_home', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Package $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('package-table')
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
            Column::make('type'),
            Column::make('price'),
            Column::make('display_at_home'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(130)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Package_' . date('YmdHis');
    }
}
