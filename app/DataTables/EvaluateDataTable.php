<?php

namespace App\DataTables;

use App\Models\Evaluate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EvaluateDataTable extends DataTable
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
                $btnDelete = '<a href="' . route('admin.evaluate.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnDelete;
            })
            ->addColumn('listing', function ($query) {
                return $query->listing->title;
            })
            ->addColumn('user', function ($query) {
                return $query->user->name;
            })
            ->addColumn('status', function ($query) {
                if ($query->is_accepted === 0) {
                    return
                        '<select class="form-control evalute-status" data-id="' . $query->id . '">
                            <option selected value="0">Pending</option>
                            <option value="1">Accept</option>
                        </select>';
                } else {
                    return
                        '<select class="form-control evalute-status" data-id="' . $query->id . '">
                            <option value="0">Pending</option>
                            <option selected value="1">Accept</option>
                        </select>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Evaluate $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('evaluate-table')
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
            Column::make('listing'),
            Column::make('user')->width(230),
            Column::make('rating')->width(100),
            Column::make('review'),
            Column::make('status')->width(200),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Evaluate_' . date('YmdHis');
    }
}
