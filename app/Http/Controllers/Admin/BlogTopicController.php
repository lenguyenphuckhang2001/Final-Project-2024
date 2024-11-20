<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogTopicDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogTopicController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:topic index'])->only(['index']);
        $this->middleware(['permission:topic create'])->only(['store', 'create']);
        $this->middleware(['permission:topic update'])->only(['edit', 'update']);
        $this->middleware(['permission:topic destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BlogTopicDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.blog.topic.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.blog.topic.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255', 'unique:blog_topics,topic'],
            'status' => ['required', 'boolean']
        ]);

        $topic = new BlogTopic();
        $topic->topic = $request->topic;
        $topic->slug = \Str::slug($request->topic);
        $topic->status = $request->status;
        $topic->save();

        toastr()->success('New topic created successfully');

        return to_route('admin.blog-topic.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $topic = BlogTopic::findOrFail($id);
        return view('admin.blog.topic.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'topic' => ['nullable', 'max:255', 'unique:blog_topics,topic,' . $id],
            'status' => ['required', 'boolean']
        ]);

        $topic = BlogTopic::findOrFail($id);
        $topic->topic = $request->topic;
        $topic->slug = \Str::slug($request->topic);
        $topic->status = $request->status;
        $topic->save();

        toastr()->success('Topic updated successfully');

        return to_route('admin.blog-topic.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            BlogTopic::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Topic deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
