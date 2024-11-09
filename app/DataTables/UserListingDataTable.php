<?php

namespace App\DataTables;

use App\Models\Listing;
use Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserListingDataTable extends DataTable
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
                $btnEdit = '<a href="' . route('user.listing.edit', $query->id) . '" class="btn btn-sm btn-primary mr-2 mb-2"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . route('user.listing.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger mb-2"><i class="fas fa-trash"></i></a>';

                $btnDropdown =
                    '<div class="btn-group">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <ul class="dropdown-menu ">
                            <li><a class="dropdown-item text-capitalize" href="' . route('user.image-gallery.index', ['id' => $query->id]) . '"><i class="far fa-image"></i> Image Gallery</a></li>
                            <li><a class="dropdown-item text-capitalize" href="' . route('user.video-gallery.index', ['id' => $query->id]) . '"><i class="far fa-video"></i> Video Gallery</a></li>
                            <li><a class="dropdown-item text-capitalize" href="' . route('user.schedule.index', $query->id) . '"><i class="far fa-calendar-alt"></i> Schedule</a></li>
                        </ul>
                    </div>';
                return $btnEdit . $btnDelete . $btnDropdown;
            })
            ->addColumn('status', function ($query) {
                if ($query->status === 1) {
                    $status = "<span class='badge bg-primary'>Active</span>";
                } else {
                    $status = "";
                }
                if ($query->is_featured === 1) {
                    $featured = "<span class='badge bg-success'>Featured</span>";
                } else {
                    $featured = "";
                }
                if ($query->is_verified === 1) {
                    $verified = "<span class='badge bg-warning'>Verified</span>";
                } else {
                    $verified = "";
                }
                if ($query->is_accepted === 0) {
                    $accepted = "<span class='badge bg-secondary'>Pending</span>";
                } else {
                    $accepted = "<span class='badge bg-info'>Accepted</span>";
                }
                return $status . $featured . $verified . $accepted;
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
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Listing $model): QueryBuilder
    {
        return $model->where('user_id', Auth::user()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userlisting-table')
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
            Column::make('title'),
            Column::make('category'),
            Column::make('location'),
            Column::make('status')->width(100),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserListing_' . date('YmdHis');
    }
}
