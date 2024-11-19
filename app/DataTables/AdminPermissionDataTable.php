<?php

namespace App\DataTables;

use App\Models\AdminPermission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminPermissionDataTable extends DataTable
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
                if($query->name === 'Main Admin'){
                    return;
                } else{
                    $btnEdit = '<a href="' . route('admin.permission.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="' . route('admin.permission.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';

                    return $btnEdit . $btnDelete;
                }
            })
            ->addColumn('permissions', function ($query) {
                $data = '';

                if ($query->name === 'Main Admin') {
                    $data .= '<span class="badge badge-dark">Access All Permissions</span>';
                } else {
                    foreach ($query->permissions as $permission) {
                        $data .= '<span class="badge badge-primary text-capitalize mr-1 mb-1">' . $permission->name . '</span>';
                    }
                }
                return $data;
            })
            ->rawColumns(['action', 'permissions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roleuserpermission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make('name')->width(250),
            Column::make('permissions'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminPermission_' . date('YmdHis');
    }
}
