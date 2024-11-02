<?php

namespace App\Http\Controllers\FrontEnd;

use App\DataTables\UserListingScheduleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UserListingScheduleStoreRequest;
use App\Http\Requests\Frontend\UserListingScheduleUpdateRequest;
use App\Models\Listing;
use App\Models\ListingSchedule;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserListingScheduleController extends Controller
{
    public function index(UserListingScheduleDataTable $dataTable, string $listingId): View | JsonResponse
    {
        $listing = Listing::select('id', 'title', 'user_id')
            ->where('id', $listingId) //Phương thức where('id', $request->id) thêm điều kiện vào truy vấn, lọc các bản ghi để chỉ bao gồm bản ghi có cột id khớp với giá trị của $request->id. Đối tượng $request có thể chứa dữ liệu từ một yêu cầu HTTP, và id là một tham số được truyền trong yêu cầu đó.
            ->first(); // Select giá trị title trong query và where tới keys id và giá trị tìm kiếm là $request->id

        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }
        $titleListing = $listing;

        $dataTable->with('listingId', $listingId);

        return $dataTable->render('frontend.dashboard.listing.schedule.index', compact('titleListing', 'listingId'));
    }

    function create(Request $request, string $listingId): View
    {
        $listing = Listing::select('id', 'user_id')->where('id', $listingId)->first();
        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }

        return view('frontend.dashboard.listing.schedule.create', compact('listingId'));
    }

    function store(UserListingScheduleStoreRequest $request, string $listingId): RedirectResponse
    {
        $listing = Listing::select('id', 'user_id')->where('id', $listingId)->first();
        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }

        $schedule = new ListingSchedule();
        $schedule->listing_id = $listingId;
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Created schedule successfully');

        return to_route('user.schedule.index', $listingId);
    }

    function edit(string $id): View
    {
        $schedule = ListingSchedule::findOrFail($id);
        $listing = Listing::select('id', 'user_id')->where('id', $schedule->listing_id)->first();
        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }

        return view('frontend.dashboard.listing.schedule.edit', compact('schedule'));
    }


    function update(UserListingScheduleUpdateRequest $request, string $id): RedirectResponse
    {
        $schedule = ListingSchedule::findOrFail($id);
        $listing = Listing::select('id', 'user_id')->where('id', $schedule->listing_id)->first();
        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }

        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->status = $request->status;
        $schedule->save();

        toastr()->success('Updated schedule successfully');

        return to_route('user.schedule.index', $schedule->listing_id);
    }

    function destroy(string $id): Response
    {
        $schedule = ListingSchedule::findOrFail($id);
        $listing = Listing::select('id', 'user_id')->where('id', $schedule->listing_id)->first();
        if (!$listing) {
            abort(404, 'Listing not found'); // Nếu không tìm thấy listing, trả về lỗi 404
        }

        if ($listing->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action'); // Nếu user không trùng khớp, trả về lỗi 403
        }

        try {
            $schedule->delete();
            return response(['status' => 'success', 'message' => "Delete schedule successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
