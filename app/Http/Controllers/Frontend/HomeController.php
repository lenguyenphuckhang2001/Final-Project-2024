<?php

namespace App\Http\Controllers\Frontend;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogTopic;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Feedback;
use App\Models\Hero;
use App\Models\Listing;
use App\Models\Location;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class HomeController extends Controller
{
    function index(): View
    {
        $hero = Hero::first();
        $categories = Category::where('status', 1)->get();
        $locations = Location::where('status', 1)->get();
        $packages = Package::where('status', 1)->where('display_at_home', 1)->take(3)->get();
        $homeFeatures = Feature::where('status', 1)->take(3)->get();
        $feedbacks = Feedback::where('status', 1)->take(8)->get();
        $blogs = Blog::with('author')->where('status', 1)->orderBy('id', 'desc')->take(3)->get();

        $homeCategory = Category::withCount(['listings' => function ($query) {
            $query->where('is_accepted', 1);
        }])->where(['display_at_home' => 1, 'status' => 1])
            ->take(9)
            ->get();

        $homeLocation = Location::with(['listings' => function ($query) {
            $query->withAvg(['evaluates' => function ($query) {
                $query->where('is_accepted', 1);
            }], 'rating')
                ->withCount(['evaluates' => function ($query) {
                    $query->where('is_accepted', 1);
                }])
                ->where(['status' => 1, 'is_accepted' => 1])
                ->orderBy('id', 'desc') //Hàm orderBy sắp xếp theo thứ tự giảm dần nếu muốn tăng dần sử dụng asc
                ->limit(8)
                ->get();
        }])->where(['display_at_home' => 1, 'status' => 1])->get();

        $homeFeaturedListing = Listing::withAvg(['evaluates' => function ($query) {
            $query->where('is_accepted', 1);
        }], 'rating')->withCount(['evaluates' => function ($query) {
            $query->where('is_accepted', 1);
        }])
            ->where(['is_accepted' => 1, 'status' => 1, 'is_featured' => 1])
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();

        return view(
            'frontend.home.index',
            compact(
                'hero',
                'categories',
                'packages',
                'locations',
                'feedbacks',
                'blogs',
                'homeFeatures',
                'homeCategory',
                'homeLocation',
                'homeFeaturedListing'
            )
        );
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


}
