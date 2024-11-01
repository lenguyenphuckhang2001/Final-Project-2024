<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FacilityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FacilityStoreRequest;
use App\Http\Requests\Admin\FacilityUpdateRequest;
use App\Models\Facility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class ListingFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FacilityDataTable $dataTable): View  | JsonResponse
    {
        return $dataTable->render('admin.facility.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.facility.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacilityStoreRequest $request): RedirectResponse
    {
        $facility = new Facility();
        $facility->icon = $request->icon;
        $facility->name = $request->name;
        $facility->slug = Str::slug($request->name);
        $facility->status = $request->status;
        $facility->save();

        toastr()->success('Created facility successfully');

        return to_route('admin.facility.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facility.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacilityUpdateRequest $request, string $id): RedirectResponse
    {
        $facility = Facility::findOrFail($id);
        $facility->icon = $request->filled('icon') ? $request->icon : $facility->icon;
        $facility->name = $request->name;
        $facility->slug = Str::slug($request->name);
        $facility->status = $request->status;
        $facility->save();

        toastr()->success('Updated facility successfully');

        return to_route('admin.facility.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Facility::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => "Delete facility successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
