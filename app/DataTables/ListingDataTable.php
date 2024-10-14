<?php

namespace App\DataTables;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ListingDataTable extends DataTable
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
                $edit = '<a href="' . route('admin.listing.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>';
                $delete = '<a href="' . route('admin.listing.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';

                $dropdown =
                    '<div class="btn-group dropleft">
                        <button type="button" class="btn btn-dark btn-sm ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i></button>
                        <div class="dropdown-menu dropleft">
                            <a class="dropdown-item" href="' . route('admin.image-gallery.index', ['id' => $query->id]) . '"><i class="far fa-images" style="margin-right: 8px;"></i> Image Gallery</a>
                            <a class="dropdown-item" href="' . route('admin.video-gallery.index', ['id' => $query->id]) . '"><i class="fab fa-youtube" style="margin-right: 8px;"></i> Video Gallery</a>
                            <a class="dropdown-item" href="' . route('admin.schedule.index', $query->id) . '"><i class="far fa-calendar" style="margin-right: 8px;"></i> Schedule</a>
                        </div>
                    </div>';
                return $edit . $delete . $dropdown;
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
                if ($query->status !== 1) {
                    return "<span class='badge badge-secondary'>Hide</span>";
                } else {
                    return "<span class='badge badge badge-success'>Active</span>";
                }
            })
            ->addColumn('is_featured', function ($query) {
                if ($query->is_featured !== 1) {
                    return "<span class='badge badge-secondary'>Yes</span>";
                } else {
                    return "<span class='badge badge badge-success'>No</span>";
                }
            })
            ->addColumn('is_verified', function ($query) {
                if ($query->is_verified !== 1) {
                    return "<span class='badge badge-secondary'>Yes</span>";
                } else {
                    return "<span class='badge badge badge-success'>No</span>";
                }
            })
            ->rawColumns(['image', 'status', 'action', 'is_featured', 'is_verified'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Listing $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('listing-table')
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
            Column::make('status')->width(120),
            Column::make('is_featured')->width(120),
            Column::make('is_verified')->width(120),

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
        return 'Listing_' . date('YmdHis');
    }
}
