<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageGalerry;
use App\Models\Listing;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ListingImageGalleryController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:listing index'])->only(['index']);
        $this->middleware(['permission:listing create'])->only(['store']);
        $this->middleware(['permission:listing destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $titleListing = Listing::select('title')
            ->where('id', $request->id) //Phương thức where('id', $request->id) thêm điều kiện vào truy vấn, lọc các bản ghi để chỉ bao gồm bản ghi có cột id khớp với giá trị của $request->id. Đối tượng $request có thể chứa dữ liệu từ một yêu cầu HTTP, và id là một tham số được truyền trong yêu cầu đó.
            ->first(); // Select giá trị title trong query và where tới keys id và giá trị tìm kiếm là $request->id
        $images = ImageGalerry::where('listing_id', $request->id)->get();
        return view('admin.listing.image-gallery.index', compact('titleListing', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'images' => ['required'],
            'images.*' => ['image', 'max:2048', 'mimes:png,jpg,gif'],
            'listing_id' => ['required']
        ]);

        $newImageMultiplePath = $this->multipleUploadImage($request, 'images');

        foreach ($newImageMultiplePath as $imagePath) {
            $image = new ImageGalerry();
            $image->listing_id = $request->listing_id;
            $image->image = $imagePath;
            $image->save();
        }

        toastr()->success('Images uploaded successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $image = ImageGalerry::findOrFail($id);
            $this->deleteUploadedFile($image->image);
            $image->delete();

            return response(['status' => 'success', 'message' => "Image deleted successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
