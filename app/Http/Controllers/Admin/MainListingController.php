<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingStoreRequest;
use App\Http\Requests\Admin\ListingUpdateRequest;
use App\Models\Amenity;
use App\Models\AmenityListing;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;
use Auth;

class MainListingController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ListingDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.listing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $locations = Location::all();
        $amenities = Amenity::all();
        return view('admin.listing.create', compact('categories', 'locations', 'amenities'));
    }

    /**
     * Store a newly created resourc e in storage.
     */
    public function store(ListingStoreRequest $request): RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');
        $thumbnailPath = $this->uploadImage($request, 'thumbnail');
        $attachmentPath = $this->uploadImage($request, 'attachment');

        $listing = new Listing();
        $listing->user_id = Auth::user()->id;
        $listing->image = $imagePath;
        $listing->thumbnail = $thumbnailPath;
        $listing->title = $request->title;
        $listing->slug = Str::slug($request->title);
        $listing->category_id = $request->category;
        $listing->location_id = $request->location;
        $listing->package_id = 0;
        $listing->phonenumber = $request->phonenumber;
        $listing->email = $request->email;
        $listing->address = $request->address;
        $listing->description = $request->description;
        $listing->website = $request->website;
        $listing->fb_url = $request->fb_url;
        $listing->x_url = $request->x_url;
        $listing->linked_url = $request->linked_url;
        $listing->insta_url = $request->insta_url;
        $listing->file = $attachmentPath;
        $listing->map_embed_code = $request->map_embed_code;
        $listing->seo_title = $request->seo_title;
        $listing->seo_description = $request->seo_description;
        $listing->status = $request->status;
        $listing->is_featured = $request->is_featured;
        $listing->is_verified = $request->is_verified;
        $listing->expire_date = date('Y-m-d');
        $listing->save();

        // Giả sử người dùng chọn các tiện ích với IDs là [1, 2] (Wifi, Điều hòa)
        // foreach ([1, 2] as $amenityId) {
        //     $amenity = new AmenityListing();
        //     $amenity->listing_id = $listing->id;  // Gán listing_id là ID của Căn hộ A
        //     $amenity->amenity_id = $amenityId;    // Gán amenity_id là ID của tiện ích (Wifi, Điều hòa)
        //     $amenity->save(); // Lưu mỗi dòng vào bảng pivot
        // }
        foreach ($request->amenities as $amenityId) {
            $amenity = new AmenityListing();
            $amenity->listing_id = $listing->id;
            $amenity->amenity_id = $amenityId;
            $amenity->save();
        }

        toastr()->success('Created Listing Successfully');

        return to_route('admin.listing.index');
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
        $listing = Listing::findOrFail($id);
        $categories = Category::all();
        $locations = Location::all();
        $amenities = Amenity::all();

        // Lấy tất cả các amenity_id từ bảng AmenityListing liên quan đến listing hiện tại
        $listingAmenities = AmenityListing::where('listing_id', $listing->id) // Lọc các bản ghi theo listing_id với Model::where('column', 'operator', 'value') sẽ mặc định là = nếu operator không có giá trị so sánh nào
            ->pluck('amenity_id') // Chỉ lấy giá trị của cột amenity_id
            ->toArray(); // Chuyển đổi kết quả thành mảng PHP
        return view('admin.listing.edit', compact('listing', 'categories', 'locations', 'amenities', 'listingAmenities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingUpdateRequest $request, string $id): RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $thumbnailPath = $this->uploadImage($request, 'thumbnail', $request->old_thumbnail);
        $attachmentPath = $this->uploadImage($request, 'attachment', $request->old_attachment);

        $listing = Listing::findOrFail($id);
        $listing->user_id = Auth::user()->id;
        $listing->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $listing->thumbnail = !empty($thumbnailPath) ? $thumbnailPath : $request->old_thumbnail;
        $listing->title = $request->title;
        $listing->slug = Str::slug($request->title);
        $listing->category_id = $request->category;
        $listing->location_id = $request->location;
        $listing->package_id = 0;
        $listing->phonenumber = $request->phonenumber;
        $listing->email = $request->email;
        $listing->address = $request->address;
        $listing->description = $request->description;
        $listing->website = $request->website;
        $listing->fb_url = $request->fb_url;
        $listing->x_url = $request->x_url;
        $listing->linked_url = $request->linked_url;
        $listing->insta_url = $request->insta_url;
        $listing->file = !empty($attachmentPath) ? $attachmentPath : $request->old_attachment;
        $listing->map_embed_code = $request->map_embed_code;
        $listing->seo_title = $request->seo_title;
        $listing->seo_description = $request->seo_description;
        $listing->status = $request->status;
        $listing->is_featured = $request->is_featured;
        $listing->is_verified = $request->is_verified;
        $listing->expire_date = date('Y-m-d');
        $listing->save();

        AmenityListing::where('listing_id', $listing->id)->delete();
        foreach ($request->amenities as $amenityId) {
            $amenity = new AmenityListing();
            $amenity->listing_id = $listing->id;
            $amenity->amenity_id = $amenityId;
            $amenity->save();
        }

        toastr()->success('Updated Listing Successfully');

        return to_route('admin.listing.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
