<?php

namespace App\DataTables;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogCommentDataTable extends DataTable
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
                $btnDelete = '<a href="' . route('admin.blog-comment.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnDelete;
            })
            ->addColumn('user', function ($query) {
                return $query->user->name;
            })
            ->addColumn('blog', function ($query) {
                return $query->blog->title;
            })
            ->addColumn('status', function ($query) {
                if ($query->status === 0) {
                    return '<select class="form-control status-comment" data-id="' . $query->id . '">
                                <option selected value="0">Pending</option>
                                <option value="1">Accept</option>
                            </select>';
                } else {
                    return '<select class="form-control status-comment" data-id="' . $query->id . '">
                                <option value="0">Pending</option>
                                <option selected value="1">Accept</option>
                            </select>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BlogComment $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blogcomment-table')
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
            Column::make('id')->width(80),
            Column::make('blog')->width(500),
            Column::make('user'),
            Column::make('message'),
            Column::make('status')->width(150),
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
        return 'BlogComment_' . date('YmdHis');
    }
}
