<?php

namespace App\DataTables;

use App\Models\Listing;
use App\Models\ListingPending;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ListingPendingDataTable extends DataTable
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
                $btnEdit = '<a href="' . route('admin.listing.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('admin.listing.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';

                $btnDropdown =
                    '<div class="btn-group dropleft">
                    <button type="button" class="btn btn-dark btn-sm ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i></button>
                    <div class="dropdown-menu dropleft">
                        <a class="dropdown-item" href="' . route('admin.image-gallery.index', ['id' => $query->id]) . '"><i class="far fa-images" style="margin-right: 8px;"></i> Image Gallery</a>
                        <a class="dropdown-item" href="' . route('admin.video-gallery.index', ['id' => $query->id]) . '"><i class="fab fa-youtube" style="margin-right: 8px;"></i> Video Gallery</a>
                        <a class="dropdown-item" href="' . route('admin.schedule.index', $query->id) . '"><i class="far fa-calendar" style="margin-right: 8px;"></i> Schedule</a>
                    </div>
                </div>';
                return $btnEdit . $btnDelete . $btnDropdown;
            })
            ->addColumn('image', function ($query) {
                return '<img width="130" height="80" src="' . asset($query->image) . '">';
            })
            ->addColumn('author', function ($query) {
                return $query->user?->name;
            })
            ->addColumn('category', function ($query) {
                return $query->category->name;
            })
            ->addColumn('location', function ($query) {
                return $query->location->name;
            })
            ->addColumn('status', function ($query) {
                $change =
                    '<select class="form-control select-pending" data-id="' . $query->id . '">
                        <option value="0">Pending</option>
                        <option value="1">Accept</option>
                    </select>';

                return $change;
            })

            ->rawColumns(['image', 'status', 'action',])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Listing $model): QueryBuilder
    {
        return $model->where('is_accepted', 0)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('listingpending-table')
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
            Column::make('image')->width(220),
            Column::make('title')->width(250),
            Column::make('author')->width(250),
            Column::make('category'),
            Column::make('location'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(170)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ListingPending_' . date('YmdHis');
    }
}
