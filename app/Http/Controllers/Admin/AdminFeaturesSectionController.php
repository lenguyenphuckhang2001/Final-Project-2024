<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FeaturesDataTable;
use App\DataTables\FeaturesSectionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeaturesSectionStoreRequest;
use App\Http\Requests\Admin\FeaturesSectionUpdateRequest;
use App\Models\Feature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminFeaturesSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FeaturesSectionDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.features.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeaturesSectionStoreRequest $request): RedirectResponse
    {
        $feature = new Feature();
        $feature->icon = $request->icon;
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->status = $request->status;
        $feature->save();

        toastr()->success('New feature created successfully');

        return to_route('admin.features.index');
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
        $feature = Feature::findOrFail($id);
        return view('admin.features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeaturesSectionUpdateRequest $request, string $id): RedirectResponse
    {
        $feature = Feature::findOrFail($id);
        /* Trường field có tồn tại trong request hay không.
        Trường field không có giá trị rỗng (không phải null, '', hoặc mảng trống [])*/
        $feature->icon = $request->filled('icon') ? $request->icon : $feature->icon;
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->status = $request->status;
        $feature->save();

        toastr()->success('Feature updated successfully');

        return to_route('admin.features.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            Feature::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Feature deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
