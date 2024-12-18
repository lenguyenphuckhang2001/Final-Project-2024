<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingScheduleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingScheduleStoreRequest;
use App\Http\Requests\Admin\ListingScheduleUpdateRequest;
use App\Models\Listing;
use App\Models\ListingSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ListingScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:listing index'])->only(['index']);
        $this->middleware(['permission:listing create'])->only(['store', 'create']);
        $this->middleware(['permission:listing update'])->only(['edit', 'update']);
        $this->middleware(['permission:listing destroy'])->only(['destroy']);
    }

    public function index(ListingScheduleDataTable $dataTable, string $listingId): View | JsonResponse
    {
        $titleListing = Listing::select('title')
            ->where('id', $listingId) //Phương thức where('id', $request->id) thêm điều kiện vào truy vấn, lọc các bản ghi để chỉ bao gồm bản ghi có cột id khớp với giá trị của $request->id. Đối tượng $request có thể chứa dữ liệu từ một yêu cầu HTTP, và id là một tham số được truyền trong yêu cầu đó.
            ->first(); // Select giá trị title trong query và where tới keys id và giá trị tìm kiếm là $request->id
        $dataTable->with('listingId', $listingId);
        return $dataTable->render('admin.listing.schedule.index', compact('titleListing', 'listingId'));
    }

    function create(Request $request, string $listingId): View
    {

        return view('admin.listing.schedule.create', compact('listingId'));
    }

    function store(ListingScheduleStoreRequest $request, string $listingId): RedirectResponse
    {
        $schedule = new ListingSchedule();
        $schedule->listing_id = $listingId;
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Schedule created successfully');

        return to_route('admin.schedule.index', $listingId);
    }

    function edit(string $id): View
    {
        $schedule = ListingSchedule::findOrFail($id);
        return view('admin.listing.schedule.edit', compact('schedule'));
    }

    function update(ListingScheduleUpdateRequest $request, string $id): RedirectResponse
    {
        $schedule = ListingSchedule::findOrFail($id);
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Schedule updated successfully');

        return to_route('admin.schedule.index', $schedule->listing_id);
    }

    function destroy(string $id): Response
    {
        try {
            $schedule = ListingSchedule::findOrFail($id);
            $schedule->delete();

            return response(['status' => 'success', 'message' => "Schedule deleted successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
