<?php

namespace App\DataTables;

use App\Models\ListingSchedule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserListingScheduleDataTable extends DataTable
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
                $btnEdit = '<a href="' . route('user.schedule.edit', $query->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('user.schedule.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnEdit . $btnDelete;
            })
            ->addColumn('status', function ($query) {
                if ($query->status !== 1) {
                    return "<span class='badge bg-secondary'>Hide</span>";
                } else {
                    return "<span class='badge bg-success'>Active</span>";
                }
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ListingSchedule $model): QueryBuilder
    {
        return $model->where('listing_id', $this->listingId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userlistingschedule-table')
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
            Column::make('day'),
            Column::make('start_time'),
            Column::make('end_time'),
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
        return 'UserListingSchedule_' . date('YmdHis');
    }
}
