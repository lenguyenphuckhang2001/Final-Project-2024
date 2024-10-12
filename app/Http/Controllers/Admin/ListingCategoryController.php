<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

use function Pest\Laravel\delete;

class ListingCategoryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
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

        toastr()->success("Created category successfully");

        return to_route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id): RedirectResponse
    {
        $iconPath = $this->uploadImage($request, 'icon', $request->old_icon);
        $backgroundPath = $this->uploadImage($request, 'background_image', $request->old_backgroud_image);

        $category = Category::findOrFail($id);
        $category->icon = !empty($iconPath) ? $iconPath : $request->old_icon;
        $category->background_image = !empty($backgroundPath) ? $backgroundPath : $request->old_background_image;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->display_at_home = $request->display_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success('Updated successfully');

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $category = Category::findOrFail($id);

            $this->deleteFile($category->icon);
            $this->deleteFile($category->background_image);

            $category->delete();

            return response(['status' => 'success', 'message' => "Delete category successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
