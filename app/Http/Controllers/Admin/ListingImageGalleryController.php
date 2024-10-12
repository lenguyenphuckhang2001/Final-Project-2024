<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageGalerry;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ListingImageGalleryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $images = ImageGalerry::where('listing_id', $request->id)->get();
        return view('admin.listing.image-gallery.index', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => ['required'],
            'images.*' => ['image', 'max:2048', 'mimes:png,jpg,gif'],
            'listing_id' => ['required']
        ]);

        $imageMultiPath = $this->uploadMultiImage($request, 'images');

        foreach ($imageMultiPath as $imagePath) {
            $image = new ImageGalerry();
            $image->listing_id = $request->listing_id;
            $image->image = $imagePath;
            $image->save();
        }

        toastr()->success('Uploaded images successfully');

        return redirect()->back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $image = ImageGalerry::findOrFail($id);
            $this->deleteFile($image->image);
            $image->delete();

            return response(['status' => 'success', 'message' => "Delete image successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
