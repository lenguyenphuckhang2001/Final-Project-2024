<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Hero;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{
    function index(): View
    {
        $hero = Hero::first();
        $categories = Category::where('status', 1)->get();
        return view('frontend.home.index', compact('hero', 'categories'));
    }

    function listings(Request $request): View
    {
        $listings = Listing::where(['status' => 1, 'is_approved' => 1]);

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


        $listings->pagnigate(15); //Hiển thị bao nhiêu data ra màn hình
        return view('frontend.pages.listings', compact('listings'));
    }
}
