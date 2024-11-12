<?php

namespace App\DataTables;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FeedbackDataTable extends DataTable
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
                $btnEdit = '<a href="' . route('admin.feedback.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('admin.feedback.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnEdit . $btnDelete;
            })
            ->addColumn('avatar', function ($query) {
                return '<img src="' . asset($query->avatar) . '" width="80" height="80" style="object-fit: cover;"></img>';
            })
            ->addColumn('rating', function ($query) {
                $stars = '';

                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $query->rating) {
                        $stars .= '<i class="fas fa-star"></i>';
                    } else {
                        $stars .= '<i class="far fa-star"></i>';
                    }
                }
                return $stars;
            })
            ->addColumn('status', function ($query) {
                if ($query->status !== 1) {
                    return "<span class='badge badge-secondary'>Hide</span>";
                } else {
                    return "<span class='badge badge-success'>Active</span>";
                }
            })
            ->rawColumns(['action', 'status', 'avatar', 'rating'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Feedback $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('feedback-table')
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
            Column::make('id'),
            Column::make('avatar'),
            Column::make('name'),
            Column::make('position'),
            Column::make('rating'),
            Column::make('status'),
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
        return 'Feedback_' . date('YmdHis');
    }
}
