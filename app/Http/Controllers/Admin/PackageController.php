<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PackageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageStoreRequest;
use App\Http\Requests\Admin\PackageUpdateRequest;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PackageDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreRequest $request): RedirectResponse
    {
        $package = new Package();
        $package->type = $request->type;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->limit_days = $request->limit_days;
        $package->limit_listing = $request->limit_listing;
        $package->limit_photos = $request->limit_photos;
        $package->limit_video = $request->limit_video;
        $package->limit_facilities = $request->limit_facilities;
        $package->limit_featured_listing = $request->limit_featured_listing;
        $package->display_at_home = $request->display_at_home;
        $package->status = $request->status;
        $package->save();

        toastr()->success('Created new package successfully');

        return to_route('admin.packages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageUpdateRequest $request, string $id)
    {
        $package = Package::findOrFail($id);

        $package->type = $request->type;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->limit_days = $request->limit_days;
        $package->limit_listing = $request->limit_listing;
        $package->limit_photos = $request->limit_photos;
        $package->limit_video = $request->limit_video;
        $package->limit_facilities = $request->limit_facilities;
        $package->limit_featured_listing = $request->limit_featured_listing;
        $package->display_at_home = $request->display_at_home;
        $package->status = $request->status;
        $package->save();

        toastr()->success('Updated package successfully');

        return to_route('admin.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            Package::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => "Delete package successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
