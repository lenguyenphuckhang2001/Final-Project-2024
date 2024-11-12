<?php

namespace App\DataTables;

use App\Models\Support;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupportDataTable extends DataTable
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
                $btnDelete = '<a href="' . route('admin.supports.destroy', $query->id) . '" class="delete-item btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                return $btnDelete;
            })
            ->addColumn('listing', function ($query) {
                $html = '<a target="_blank" href="' . route('listing.detail', $query->listing->slug) . '">' . $query->listing->title . '</a>';
                return $html;
            })

            /** Hàm sửa lỗi search query datatables
             * Hàm filterColumn() là câu lệnh cho phép áp dụng bộ lọc trong datatable
             * $keyword là tham số truy vấn chính của người dùng khi tìm kiếm
             * orWhereHas để tìm các bản ghi có mối quan hệ với listing mà trường title chứa từ khóa là $keyword
             *
             * Hàm where('column', 'operator', 'value') nhận 3 đối số với điều kiện đầu tiên là
             * column => 'title' Đây là cột của bảng mà chúng ta muốn lọc dữ liệu
             * operator => 'like' Là một toán tử SQL dùng để tìm kiếm chuỗi tương tự, cho phép tìm kiếm các từ khóa
             * value => ''%' . $keyword . '%''
             *  >> % là ký tự đặc biệt trong SQL, dùng để biểu thị bất kỳ chuỗi nào (bao gồm chuỗi rỗng).
             *  >> '% . $keyword . %' có nghĩa là tìm kiếm mọi bản ghi có chứa $keyword ở bất kỳ vị trí nào trong title:
             *    -> %keyword%: Tìm từ khóa $keyword ở bất kỳ vị trí nào trong title
             *    -> keyword%: Tìm từ khóa bắt đầu bằng $keyword
             *    -> %keyword: Tìm từ khóa kết thúc bằng $keyword
             */
            ->filterColumn('listing', function ($query, $keyword) {
                $query->orWhereHas('listing', function ($subQuery) use ($keyword) {
                    $subQuery->where('title', 'like', '%' . $keyword . '%');
                });
            })


            ->rawColumns(['action', 'listing'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Support $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('support-table')
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
            Column::make('name')->width(120),
            Column::make('email')->width(120),
            Column::make('listing')->width(150),
            Column::make('message'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Support_' . date('YmdHis');
    }
}
