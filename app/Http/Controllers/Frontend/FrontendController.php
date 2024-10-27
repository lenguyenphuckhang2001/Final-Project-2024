<?php

namespace App\Http\Controllers\Frontend;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Evaluate;
use App\Models\Hero;
use App\Models\Listing;
use App\Models\ListingSchedule;
use App\Models\Location;
use App\Models\Package;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FrontendController extends Controller
{
    function index(): View
    {
        $hero = Hero::first();
        $categories = Category::where('status', 1)->get();
        $packages = Package::where('status', 1)->where('display_at_home', 1)->take(3)->get();

        $ourCategory = Category::withCount(['listings' => function ($query) {
            $query->where('is_approved', 1);
        }])->where(['display_at_home' => 1, 'status' => 1])
            ->take(6)
            ->get();

        $ourLocation = Location::with(['listings' => function ($query) {
            $query->withAvg(['evaluates' => function ($query) {
                $query->where('is_approved', 1);
            }], 'rating')
                ->withCount(['evaluates' => function ($query) {
                    $query->where('is_approved', 1);
                }])
                ->where(['status' => 1, 'is_approved' => 1])
                ->orderBy('id', 'desc') //Hàm orderBy sắp xếp theo thứ tự giảm dần nếu muốn tăng dần sử dụng asc
                ->limit(8)
                ->get();
        }])->where(['display_at_home' => 1, 'status' => 1])->get();

        $ourFeaturedListing = Listing::withAvg(['evaluates' => function ($query) {
            $query->where('is_approved', 1);
        }], 'rating')->withCount(['evaluates' => function ($query) {
            $query->where('is_approved', 1);
        }])
            ->where(['is_approved' => 1, 'status' => 1, 'is_featured' => 1])
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();

        return view(
            'frontend.home.index',
            compact(
                'hero',
                'categories',
                'packages',
                'ourCategory',
                'ourLocation',
                'ourFeaturedListing'
            )
        );
    }

    function listings(Request $request): View
    {
        $listings = Listing::withAvg(['evaluates' => function ($query) {
            $query->where('is_approved', 1);
        }], 'rating')->withCount(['evaluates' => function ($query) {
            $query->where('is_approved', 1);
        }])
            ->with(['category', 'location'])
            ->where(['status' => 1, 'is_approved' => 1]); //Hàm with sẽ load động dữ liệu cùng với bảng khi được gọi

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
        $listings->when($request->has('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });


        $listings = $listings->paginate(9); //Hiển thị bao nhiêu data ra màn hình

        return view('frontend.pages.listings', compact('listings'));
    }


    function listingModal(string $id)
    {
        $listing = Listing::findOrFail($id);

        return view('frontend.layouts.ajax-model-listing', compact('listing'))->render();
    }

    function detailListing(string $slug): View
    {
        // Lấy danh sách theo slug và kiểm tra trạng thái hoạt động và xác minh
        $listing = Listing::withAvg(['evaluates' => function ($query) { //Hàm tính tổng trung bình của các cột được chỉ định ở đây là evaluates với mối quan hệ với listings
            $query->where('is_approved', 1); //Điều kiện là approved phải bằng 1 nghĩa là cho phép
        }], 'rating') //Cột cần tính trung bình. Ở đây là cột 'rating' trong bảng đánh giá (evaluations).
            ->where(['status' => 1, 'is_verified' => 1]) // Điều kiện tìm kiếm: chỉ lấy các danh sách có status = 1 và is_verified = 1
            ->where('slug', $slug) // Điều kiện bổ sung: lấy danh sách có slug khớp với giá trị $slug (thường là tham số từ URL)
            ->first(); // Lấy bản ghi đầu tiên thỏa mãn các điều kiện. Nếu không có bản ghi nào, sẽ trả về null

        /**
         * Ví dụ giải thích thêm:
         *
         * status = 1: biểu thị rằng danh sách này đang hoạt động (có thể là đã duyệt hoặc cho phép hiển thị).
         * is_verified = 1: biểu thị rằng danh sách này đã được xác minh (phê duyệt hoặc hợp lệ).
         * slug: thường là chuỗi đại diện cho tên duy nhất của danh sách, có thể được dùng để xác định bản ghi một cách thân thiện với người dùng.
         *
         * Kết quả của câu lệnh:
         * Nếu tìm thấy bản ghi thỏa mãn cả hai điều kiện status = 1, is_verified = 1 và slug khớp với $slug, biến $listing sẽ chứa đối tượng Listing đó.
         * Nếu không tìm thấy, $listing sẽ là null.
         */


        // Tìm các danh sách tương tự dựa trên danh mục của danh sách hiện tại
        $similarListing = Listing::withCount(['evaluates' => function ($query) {
            $query->where('is_approved', 1);
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
        $evaluates = Evaluate::with('user')->where(['listing_id' =>  $listing->id, 'is_approved' => 1])->paginate(8);

        return view('frontend.pages.listing-detail', compact('listing', 'similarListing', 'statusTime', 'evaluates'));
    }

    function showPackages(): View
    {
        $packages = Package::where('status', 1)->where('display_at_home', 1)->get();
        return view('frontend.pages.packages', compact('packages'));
    }

    function checkout(string $id): View | RedirectResponse
    {
        $package = Package::findOrFail($id);

        /**
         * Lưu ID của gói được chọn vào session
         * 'selected_package_id' là khóa để nhận diện giá trị trong session
         * $package->id là ID của gói dịch vụ hoặc sản phẩm mà người dùng đã chọn
         */
        Session::put('selected_package_id', $package->id);

        if ($package->type === 'free' || $package->price == 0) {
            $paymentInfo = [
                'transaction_id' => uniqid(),
                'payment_status' => 'completed',
                'payment_method' => 'Free',
                'paid_amount' => 0,
                'paid_currency' => config('settings.site_default_currency'),
            ];

            CreateOrder::dispatch($paymentInfo);
            toastr()->success('Register free package successfully');
            return redirect()->route('admin.dashboard.index');
        }

        return view('frontend.pages.checkout', compact('package'));
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

        toastr()->success('Your review has been added. Waiting admin approve your comment');

        return redirect()->back();
    }

    function reportListing(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'max:500'],
            'listing_id' => ['required', 'integer']
        ]);

        $report = new Report();
        $report->listing_id = $request->listing_id;
        $report->name = $request->name;
        $report->email = $request->email;
        $report->message = $request->message;
        $report->save();

        toastr()->success('Your report has been submited');

        return redirect()->back();
    }
}
