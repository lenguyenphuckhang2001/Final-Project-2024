<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ImageGalerry;
use App\Models\Listing;
use App\Models\Subscription;
use App\Rules\LimitImages;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ListingAgentImageGalleryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $titleListing = Listing::select('title')
            ->where('id', $request->id) //Phương thức where('id', $request->id) thêm điều kiện vào truy vấn, lọc các bản ghi để chỉ bao gồm bản ghi có cột id khớp với giá trị của $request->id. Đối tượng $request có thể chứa dữ liệu từ một yêu cầu HTTP, và id là một tham số được truyền trong yêu cầu đó.
            ->first(); // Select giá trị title trong query và where tới keys id và giá trị tìm kiếm là $request->id
        $images = ImageGalerry::where('listing_id', $request->id)->get();
        return view('frontend.dashboard.listing.image-gallery.index', compact('images', 'titleListing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => ['required'],
            'images.*' => ['image', 'max:2048', 'mimes:png,jpg,gif'],
            'listing_id' => ['required', new LimitImages]
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
