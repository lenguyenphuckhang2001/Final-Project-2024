<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Evaluate;
use App\Models\Facility;
use App\Models\Listing;
use App\Models\ListingSchedule;
use App\Models\Location;
use App\Models\Support;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GuestListingController extends Controller
{
    function listings(Request $request): View
    {
        $listings = Listing::withAvg(['evaluates' => function ($query) {
            $query->where('is_accepted', 1);
        }], 'rating')->withCount(['evaluates' => function ($query) {
            $query->where('is_accepted', 1);
        }])
            ->with(['category', 'location'])
            ->where(['status' => 1, 'is_accepted' => 1]); //Hàm with sẽ load động dữ liệu cùng với bảng khi được gọi

        /*--------------------------------------- SEARCH FEATURES ---------------------------------------*/
        /**
         * Logic hàm listings

         * Đầu tiền hàm sẽ sử dụng hàm when($request->has('category')) để biết rằng trong $request cuả người dùng có trường category hay không,
         * nếu trong request có category thì tức là người dùng đã chọn một danh mục nào đó giả sử ở đây là home category thì nó sẽ thực hiện truy
         * vấn bên trong callback. Nếu không có truy vấn sẽ bỏ qua theo phần lọc danh mục

         * Tiếp theo sau khi đã true thì nó sẽ vào tiếp hàm $query->whereHas('category', function ($query) use ($request) với
         * whereHas('category') là một câu lệnh eloquent kiểm tra giữa listings và categories và nó sẽ lọc các listings có 1 category liên kết
         * với nó ở đây hiểu là (1 sản phẩm liên kết với 1 danh mục nào đó. Ví dụ như Tạp hóa thì có danh mục là sữa) thì nó sẽ lọc điều kiện
         * 1 hoặc nhiều hay nhiều hoặc 1 để lọc. Và sau khi lọc nếu điều kiện đáp ứng thì sử dụng tiếp hàm callback để kiểm tra

         * Ở hàm $query->where('slug', $request->category) với hàm nằm bên trong callback whereHas() sẽ truy vấn đến cột slug trong bảng categories.
         * Nó sẽ kiểm tra xem slug của category có trùng khớp với giá trị category được gửi từ request hay không. Nếu có nó sẽ trả về dữ liệu của
         * bảng categories trùng với giá trị người dùng tìm kiếm
         */

        $listings->when($request->has('category') && $request->filled('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });

        $listings->when($request->has('search') && $request->filled('search'), function ($query) use ($request) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery
                    ->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        });

        $listings->when($request->has('location') && $request->filled('location'), function ($query) use ($request) {
            $query->whereHas('location', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->location);
            });
        });

        /** Giải thích hàm search query của facilities
         * Đầu tiên sử dụng when để biết khi nào thêm điều kiện query dựa trên 1 logic cụ thể
         * $request->has('facility') sẽ kiểm tra xem request có chứa key 'facility' không.
         * is_array($request->facility) sẽ kiểm tra xem facility trong request có phải là một mảng không.
         *
         * $facilityId = Facility::whereIn('slug', $request->facility)->pluck('id')
         * Sử dụng whereIn để lọc các facilities có cột slug nằm trong danh sách slug mà người dùng gửi qua $request->facility
         * Sau khi đã có các danh sách dựa trên slug, pluck('id') sẽ trả về một danh sách mà chỉ có id mà không có giá trị của trường đó
         *
         * Ví dụ : $request->facility là mảng sẽ chứa các tiện ích người dùng muốn tim ví dụ ['pool', 'wifi', 'gym']
         * pluck('id') nếu các tiện ích có slug là pool, wifi, và gym có id lần lượt là 1, 2, và 3, thì pluck('id') sẽ trả về [1, 2, 3] mà không kèm theo dữ liệu
         *
         * whereHas để kiểm tra xem các giá trị facility có liên kết với bảng facilities hay không.
         * Giả sử muốn tìm các listings có tiện ích thuộc danh sách [1, 2, 3]. Sử dụng whereHas để kiểm tra xem mỗi listing có liên kết với ít nhất một facility có id thuộc [1, 2, 3].
         * Sử dụng thêm whereIn để lọc đảm bảo listing chỉ được trả về nếu nó có ít nhất một facility có id thuộc [1, 2, 3].
         */

        $listings->when($request->has('facility') && is_array($request->facility), function ($query) use ($request) {
            $facilityId = Facility::whereIn('slug', $request->facility)->pluck('id');

            $query->whereHas('facilities', function ($subQuery) use ($facilityId) {
                $subQuery->whereIn('facility_id', $facilityId);
            });
        });

        $categories = Category::where('status', 1)->get();
        $locations = Location::where('status', 1)->get();
        $facilities = Facility::where('status', 1)->get();

        $listings = $listings->paginate(9); //Hiển thị bao nhiêu dữ liệu ra màn hình

        return view(
            'frontend.pages.listings',
            compact(
                'listings',
                'categories',
                'locations',
                'facilities'
            )
        );
    }

    function listingModal(string $id)
    {
        $listing = Listing::findOrFail($id);

        return view('frontend.components.info-popup', compact('listing'))->render();
    }

    function detailListing(string $slug): View
    {
        // Lấy danh sách theo slug và kiểm tra trạng thái hoạt động và xác minh
        $listing = Listing::withAvg(['evaluates' => function ($query) { //Hàm tính tổng trung bình của các cột được chỉ định ở đây là evaluates với mối quan hệ với listings
            $query->where('is_accepted', 1); //Điều kiện là accepted phải bằng 1 nghĩa là cho phép
        }], 'rating') //Cột cần tính trung bình. Ở đây là cột 'rating' trong bảng đánh giá (evaluations).
            ->where(['status' => 1, 'is_accepted' => 1]) // Điều kiện tìm kiếm: chỉ lấy các danh sách có status = 1 và is_accepted = 1
            ->where('slug', $slug) // Điều kiện bổ sung: lấy danh sách có slug khớp với giá trị $slug (thường là tham số từ URL)
            ->firstOrFail(); // Lấy bản ghi đầu tiên thỏa mãn các điều kiện. Nếu không có bản ghi nào, sẽ trả về null


        // Tìm các danh sách tương tự dựa trên danh mục của danh sách hiện tại
        $discoverMoreListing = Listing::withCount(['evaluates' => function ($query) {
            $query->where('is_accepted', 1);
        }])
            ->where('category_id', $listing->category_id) // Điều kiện: tìm các danh sách có cùng category_id với danh sách hiện tại
            ->where('id', '!=', $listing->id) // Điều kiện: loại trừ danh sách hiện tại bằng cách đảm bảo id khác với $listing->id bằng dấu !=
            ->orderBy('id', 'DESC') // Sắp xếp kết quả theo thứ tự giảm dần của id (danh sách mới nhất sẽ nằm trên đầu)
            ->take(5) // Giới hạn kết quả trả về chỉ gồm 5 danh sách
            ->get(); // Lấy tất cả các bản ghi thỏa mãn điều kiện dưới dạng một Collection
        /**
         * Ví dụ giải thích thêm:
         *
         * category_id: biểu thị danh mục mà danh sách thuộc về. Điều này giúp tìm các danh sách khác thuộc cùng một danh mục.
         * id != $listing->id: điều kiện này đảm bảo rằng danh sách hiện tại không được bao gồm trong danh sách các kết quả trả về.
         * orderBy('id', 'DESC'): sắp xếp theo id từ lớn đến nhỏ (danh sách mới nhất trước).
         * take(5): chỉ lấy tối đa 5 bản ghi, giới hạn số lượng kết quả để tránh quá tải.
         *
         * Kết quả của câu lệnh:
         * Truy vấn sẽ trả về tối đa 5 danh sách khác cùng danh mục với danh sách hiện tại, sắp xếp từ danh sách mới nhất đến cũ hơn.
         * Những danh sách này sẽ được dùng để gợi ý các sản phẩm hoặc danh sách tương tự trên trang chi tiết của danh sách hiện tại.
         */

        /***************************Xử lý thời gian thực tế***************************/
        //Mặc địch giá trị sẽ là empty
        $statusTime = '';

        $formatDay = ListingSchedule::where('listing_id', $listing->id)->where('day', \Str::lower(date('l')))->first();
        if ($formatDay) {
            $startTime = strtotime($formatDay->start_time);
            $endTime = strtotime($formatDay->end_time);
            if (time() >= $startTime && time() <= $endTime) {
                $statusTime = 'true';
            } else {
                $statusTime = 'false';
            }
        }

        /* Sử dụng hàm incrementđể mỗi lần refresh page sẽ tăng lên 1 view */
        $listing->increment('views');

        /*Khởi tạo intance của evaluates với việc thêm các trường để query chúng */
        $evaluates = Evaluate::with('user')->where(['listing_id' =>  $listing->id, 'is_accepted' => 1])->paginate(8);

        return view('frontend.pages.listing-detail', compact('listing', 'discoverMoreListing', 'statusTime', 'evaluates'));
    }

    function evaluateListing(Request $request): RedirectResponse
    {
        $request->validate([
            'rating' => ['required', 'in:1,2,3,4,5'],
            'review' => ['required'],
            'listing_id' => ['required', 'integer'],
        ]);

        $identifyEvaluate = Evaluate::where(['listing_id' => $request->listing_id, 'user_id' => auth()->user()->id])->exists();
        if ($identifyEvaluate) {
            throw ValidationException::withMessages(['You have commented on this post']);
        }

        $evaluate = new Evaluate();
        $evaluate->listing_id = $request->listing_id;
        $evaluate->user_id = auth()->user()->id;
        $evaluate->rating = $request->rating;
        $evaluate->review = $request->review;
        $evaluate->save();

        toastr()->success('Your review has been added. Waiting admin accept your review');

        return redirect()->back();
    }

    function supportListing(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'max:500'],
            'listing_id' => ['required', 'integer']
        ]);

        $support = new Support();
        $support->listing_id = $request->listing_id;
        $support->name = $request->name;
        $support->email = $request->email;
        $support->message = $request->message;
        $support->save();

        toastr()->success('Your support has been submited');

        return redirect()->back();
    }

}
