<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestBlogController extends Controller
{
    function blogIndex(Request $request): View
    {
        $blogs = Blog::with('author')
            ->where('status', 1)
            /**
             * Hàm xử lý search
             * has('search') kiểm tra xem liệu có trường search trong yêu cầu gửi lên không. Nếu có thì true, ngược lại false
             * filled('search') kiểm tra xem trường search không chỉ có mặt trong yêu cầu mà còn có giá trị hợp lệ. Nếu có gtr trả về true ngược lại false
             */
            ->when($request->has('search') && $request->filled('search'), function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery
                        ->where('title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('content', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->when($request->has('topic') && $request->filled('topic'), function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    /**
                     * Câu lệnh select cho mối qh 1 - n với select để chọn các trường liên quan đến bảng ở đây là id và slug
                     * Đk where('slug', $request->topic) tìm kiếm bản ghi trong bảng BlogTopic có slug khớp với $request->topic (thường được truyền qua URL, ví dụ: /blogs?topic=lifestyle)
                     * $subQuery->where('topic_id', $topic->id)
                     * Điều kiện này chỉ lấy các bài blog có topic_id khớp với id của chủ đề vừa tìm thấy
                     * Nếu slug lifestyle khớp với một topic có id = 2, thì điều kiện này lọc ra các bài blog có topic_id = 2
                     *
                     * VD cụ thể:
                     * URL là /blogs?topic=lifestyle
                     * B1: Lấy slug từ URL là: $request->topic nhận giá trị là lifestyle
                     * B2: Tìm chủ đề trong bảng BLogTopic tìm chủ đề có slug lifestyle. Nếu tìm thấy thêm 1 chủ đề với id = 2 thì $topic sẽ là đối tượng BlogTopic chứa
                     * dữ liệu {id: 2, slug: 'lifestyle'}
                     * B3: Truy vấn thêm dk where('topic_id', 2)
                     * => Kq trả về là topic_id = 2 trả về chủ đề của lifestyle
                     */
                    $topic = BlogTopic::select('id', 'slug')->where('slug', $request->topic)->first();
                    $subQuery->where('topic_id', $topic->id);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(6);

        $topics = BlogTopic::withCount(['blogs' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();

        return view('frontend.pages.blogs', compact('blogs', 'topics'));
    }

    function blogDetail(string $slug): View
    {
        $blog = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with('topic')
            ->where(['status' => 1, 'slug' => $slug])
            ->firstOrFail();

        $comments = $blog->comments()
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(8);

        $relatedBlogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->where('topic_id', $blog->topic_id)
            ->where('id', '!=', $blog->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $blog->increment('view');

        return view('frontend.pages.blog-detail', compact('blog', 'comments', 'relatedBlogs'));
    }

    function blogComment(Request $request): RedirectResponse
    {
        $request->validate([
            'blog_id' => ['required', 'integer'],
            'message' => ['required'],
        ]);

        $comment = new BlogComment();
        $comment->user_id = auth()->user()->id;
        $comment->blog_id = $request->blog_id;
        $comment->message = $request->message;
        $comment->save();

        toastr()->success('Comment this post successfully');

        return redirect()->back();
    }
}
