<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class BlogCommentController extends Controller
{
    function index(BlogCommentDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.blog.comment-status.index');
    }

    function updateStatus(Request $request): Response
    {
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $comment = BlogComment::findOrFail($request->id);
        $comment->status = $request->status;
        $comment->save();

        return response(['status' => 'success', 'message' => 'Update this comment status successfully']);
    }

    function destroy(string $id): Response
    {
        try {
            BlogComment::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Comment blog deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
