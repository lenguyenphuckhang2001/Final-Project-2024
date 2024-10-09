<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Models\Category;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;

class ListingCategoryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable) : View | JsonResponse
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $iconPath = $this->uploadImage($request, 'icon');
        $backgroundPath = $this->uploadImage($request, 'background_image');

        $category = new Category();
        $category->icon = $iconPath;
        $category->background_image = $backgroundPath;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->display_at_home = $request->display_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success("Created successfully");

        return to_route('admin.category.index');

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
    public function destroy(string $id)
    {
        //
    }
}
