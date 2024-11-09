<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingStoreRequest;
use App\Http\Requests\Admin\ListingUpdateRequest;
use App\Models\Facility;
use App\Models\FacilityListing;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;
use Auth;

class MainListingController extends Controller
{
    use FileHandlingTrait;
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
        $facilities = Facility::all();
        return view('admin.listing.create', compact('categories', 'locations', 'facilities'));
    }

    /**
     * Store a newly created resourc e in storage.
     */
    public function store(ListingStoreRequest $request): RedirectResponse
    {
        $imagePath = $this->imageUpload($request, 'image');
        $thumbnailPath = $this->imageUpload($request, 'thumbnail');
        $attachmentPath = $this->imageUpload($request, 'attachment');

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
        $listing->is_accepted = 1;
        $listing->expire_date = date('Y-m-d');
        $listing->save();

        // Giả sử người dùng chọn các tiện ích với IDs là [1, 2] (Wifi, Điều hòa)
        // foreach ([1, 2] as $facilityId) {
        //     $facility = new FacilityListing();
        //     $facility->listing_id = $listing->id;  // Gán listing_id là ID của Căn hộ A
        //     $facility->facility_id = $facilityId;    // Gán facility_id là ID của tiện ích (Wifi, Điều hòa)
        //     $facility->save(); // Lưu mỗi dòng vào bảng pivot
        // }
        foreach ($request->facilities as $facilityId) {
            $facility = new FacilityListing();
            $facility->listing_id = $listing->id;
            $facility->facility_id = $facilityId;
            $facility->save();
        }

        toastr()->success('Listing created successfully');

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
        $facilities = Facility::all();

        // Lấy tất cả các facility_id từ bảng FacilityListing liên quan đến listing hiện tại
        $listingFacilities = FacilityListing::where('listing_id', $listing->id) // Lọc các bản ghi theo listing_id với Model::where('column', 'operator', 'value') sẽ mặc định là = nếu operator không có giá trị so sánh nào
            ->pluck('facility_id') // Chỉ lấy giá trị của cột facility_id
            ->toArray(); // Chuyển đổi kết quả thành mảng PHP
        return view('admin.listing.edit', compact('listing', 'categories', 'locations', 'facilities', 'listingFacilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingUpdateRequest $request, string $id): RedirectResponse
    {

        $imagePath = $this->imageUpload($request, 'image', $request->old_image);
        $thumbnailPath = $this->imageUpload($request, 'thumbnail', $request->old_thumbnail);
        $attachmentPath = $this->imageUpload($request, 'attachment', $request->old_attachment);

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

        FacilityListing::where('listing_id', $listing->id)->delete();
        foreach ($request->facilities as $facilityId) {
            $facility = new FacilityListing();
            $facility->listing_id = $listing->id;
            $facility->facility_id = $facilityId;
            $facility->save();
        }

        toastr()->success('Listing updated successfully');

        return to_route('admin.listing.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Listing::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => "Listing deleted successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
