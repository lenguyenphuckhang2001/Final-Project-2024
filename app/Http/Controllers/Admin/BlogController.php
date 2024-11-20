<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogTopic;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:blog index'])->only(['index']);
        $this->middleware(['permission:blog create'])->only(['store', 'create']);
        $this->middleware(['permission:blog update'])->only(['edit', 'update']);
        $this->middleware(['permission:blog destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $topics = BlogTopic::where('status', 1)->get();
        return view('admin.blog.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request): RedirectResponse
    {
        $newImagePath = $this->imageUpload($request, 'image');

        $blog = new Blog();
        $blog->author_id = auth()->user()->id;
        $blog->image = $newImagePath;
        $blog->topic_id = $request->topic;
        $blog->title = $request->title;
        $blog->slug = \Str::slug($request->title);
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success('New blog created successfully');

        return redirect()->route('admin.blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $topics = BlogTopic::where('status', 1)->get();
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id): RedirectResponse
    {
        $newImagePath = $this->imageUpload($request, 'image', $request->previous_image);

        $blog = Blog::findOrFail($id);
        $blog->author_id = auth()->user()->id;
        $blog->image = !empty($newImagePath) ? $newImagePath : $request->previous_image;
        $blog->topic_id = $request->topic;
        $blog->title = $request->title;
        $blog->slug = \Str::slug($request->title);
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success('Blog updated successfully');

        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $blog = Blog::findOrFail($id);

            $this->deleteUploadedFile($blog->image);

            $blog->delete();
            return response(['status' => 'success', 'message' => 'Topic deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
