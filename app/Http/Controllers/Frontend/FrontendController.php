<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Hero;
use App\Models\Listing;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{
    function index(): View
    {
        $hero = Hero::first();
        $categories = Category::where('status', 1)->get();
        $packages = Package::where('status', 1)->where('display_at_home', 1)->take(3)->get();
        return view('frontend.home.index', compact('hero', 'categories', 'packages'));
    }

    function listings(Request $request): View
    {
        $listings = Listing::with(['category', 'location'])->where(['status' => 1, 'is_approved' => 1]); //Hàm with sẽ load động dữ liệu cùng với bảng khi được gọi

        /**Logic hàm listings
         *Đầu tiền hàm sẽ sử dụng hàm when($request->has('category')) để biết rằng trong $request cuả người dùng có trường category hay không,
        nếu trong request có category thì tức là người dùng đã chọn một danh mục nào đó giả sử ở đây là home category thì nó sẽ thực hiện truy
        vấn bên trong callback. Nếu không có truy vấn sẽ bỏ qua theo phần lọc danh mục

         *Tiếp theo sau khi đã true thì nó sẽ vào tiếp hàm $query->whereHas('category', function ($query) use ($request) với
        whereHas('category') là một câu lệnh eloquent kiểm tra giữa listings và categories và nó sẽ lọc các listings có 1 category liên kết
        với nó ở đây hiểu là (1 sản phẩm liên kết với 1 danh mục nào đó. Ví dụ như Tạp hóa thì có danh mục là sữa) thì nó sẽ lọc điều kiện
        1 hoặc nhiều hay nhiều hoặc 1 để lọc. Và sau khi lọc nếu điều kiện đáp ứng thì sử dụng tiếp hàm callback để kiểm tra

         *Ở hàm $query->where('slug', $request->category) với hàm nằm bên trong callback whereHas() sẽ truy vấn đến cột slug trong bảng categories.
        Nó sẽ kiểm tra xem slug của category có trùng khớp với giá trị category được gửi từ request hay không. Nếu có nó sẽ trả về dữ liệu của
        bảng categories trùng với giá trị người dùng tìm kiếm
         */
        $listings->when($request->has('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });


        $listings = $listings->paginate(15); //Hiển thị bao nhiêu data ra màn hình
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
        $listing = Listing::where(['status' => 1, 'is_verified' => 1]) // Điều kiện tìm kiếm: chỉ lấy các danh sách có status = 1 và is_verified = 1
            ->where('slug', $slug) // Điều kiện bổ sung: lấy danh sách có slug khớp với giá trị $slug (thường là tham số từ URL)
            ->first(); // Lấy bản ghi đầu tiên thỏa mãn các điều kiện. Nếu không có bản ghi nào, sẽ trả về null

        // Ví dụ giải thích thêm:
        // - status = 1: biểu thị rằng danh sách này đang hoạt động (có thể là đã duyệt hoặc cho phép hiển thị).
        // - is_verified = 1: biểu thị rằng danh sách này đã được xác minh (phê duyệt hoặc hợp lệ).
        // - slug: thường là chuỗi đại diện cho tên duy nhất của danh sách, có thể được dùng để xác định bản ghi một cách thân thiện với người dùng.

        // Kết quả của câu lệnh:
        // - Nếu tìm thấy bản ghi thỏa mãn cả hai điều kiện status = 1, is_verified = 1 và slug khớp với $slug, biến $listing sẽ chứa đối tượng Listing đó.
        // - Nếu không tìm thấy, $listing sẽ là null.


        // Tìm các danh sách tương tự dựa trên danh mục của danh sách hiện tại
        $similarListing = Listing::where('category_id', $listing->category_id) // Điều kiện: tìm các danh sách có cùng category_id với danh sách hiện tại
            ->where('id', '!=', $listing->id) // Điều kiện: loại trừ danh sách hiện tại bằng cách đảm bảo id khác với $listing->id bằng dấu !=
            ->orderBy('id', 'DESC') // Sắp xếp kết quả theo thứ tự giảm dần của id (danh sách mới nhất sẽ nằm trên đầu)
            ->take(5) // Giới hạn kết quả trả về chỉ gồm 5 danh sách
            ->get(); // Lấy tất cả các bản ghi thỏa mãn điều kiện dưới dạng một Collection

        // Ví dụ giải thích thêm:
        // - category_id: biểu thị danh mục mà danh sách thuộc về. Điều này giúp tìm các danh sách khác thuộc cùng một danh mục.
        // - id != $listing->id: điều kiện này đảm bảo rằng danh sách hiện tại không được bao gồm trong danh sách các kết quả trả về.
        // - orderBy('id', 'DESC'): sắp xếp theo id từ lớn đến nhỏ (danh sách mới nhất trước).
        // - take(5): chỉ lấy tối đa 5 bản ghi, giới hạn số lượng kết quả để tránh quá tải.

        // Kết quả của câu lệnh:
        // - Truy vấn sẽ trả về tối đa 5 danh sách khác cùng danh mục với danh sách hiện tại, sắp xếp từ danh sách mới nhất đến cũ hơn.
        // - Những danh sách này sẽ được dùng để gợi ý các sản phẩm hoặc danh sách tương tự trên trang chi tiết của danh sách hiện tại.

        return view('frontend.pages.listing-detail', compact('listing', 'similarListing'));
    }

    function showPackages(): View
    {
        $packages = Package::where('status', 1)->where('display_at_home', 1)->get();
        return view('frontend.pages.packages', compact('packages'));
    }
}
