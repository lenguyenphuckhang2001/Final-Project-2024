<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FeedbackDataTable;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    use FileHandlingTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(FeedbackDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.feedback.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $newAvatarPath = $this->imageUpload($request, 'avatar');

        $feedback = new Feedback();
        $feedback->avatar = $newAvatarPath;
        $feedback->name = $request->name;
        $feedback->position = $request->position;
        $feedback->rating = $request->rating;
        $feedback->comment = $request->comment;
        $feedback->status = $request->status;
        $feedback->save();

        toastr()->success('New feedback created successfully');

        return to_route('admin.feedback.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $newAvatarPath = $this->imageUpload($request, 'avatar', $request->previous_avatar);

        $feedback = Feedback::findOrFail($id);
        $feedback->avatar = !empty($newAvatarPath) ? $newAvatarPath : $request->previous_avatar;
        $feedback->name = $request->name;
        $feedback->position = $request->position;
        $feedback->rating = $request->rating;
        $feedback->comment = $request->comment;
        $feedback->status = $request->status;
        $feedback->save();

        toastr()->success('Feedback updated successfully');

        return to_route('admin.feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $feedback = Feedback::findOrFail($id);

            $this->deleteUploadedFile($feedback->avatar);

            $feedback->delete();
            return response(['status' => 'success', 'message' => 'Feedback deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
