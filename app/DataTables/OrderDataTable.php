<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
                $btnInfo = '<a href="' . route('admin.orders.show', $query->id) . '" class="btn btn-sm btn-info mr-2"><i class="fas fa-info-circle"></i></a>';
                $btnDelete = '<a href="' . route('admin.orders.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnInfo . $btnDelete;
            })
            ->addColumn('email', function ($query) {
                return $query->user->email;
            })
            ->addColumn('package', function ($query) {
                return $query->package->name;
            })
            ->addColumn('payment', function ($query) {
                return $query->base_amount . ' ' . $query->base_currency;
            })
            ->addColumn('payment_status', function ($query) {
                if ($query->payment_status === 'completed') {
                    return "<span class='badge badge-success'>Completed</span>";
                } elseif ($query->payment_status === 'pending') {
                    return "<span class='badge badge-secondary'>Pending</span>";
                } else {
                    return "<span class='badge badge-danger'>Failed</span>";
                }
            })
            ->rawColumns(['payment_status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('order-table')
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
            Column::make('id')->width(50),
            Column::make('email'),
            Column::make('package'),
            Column::make('payment_method'),
            Column::make('payment'),
            Column::make('payment_status'),

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
        return 'Order_' . date('YmdHis');
    }
}
