<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

use function Pest\Laravel\delete;

class ListingCategoryController extends Controller
{
    use FileHandlingTrait;
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
        $newIconPath = $this->imageUpload($request, 'icon');
        $newBackgroundPath = $this->imageUpload($request, 'background_image');

        $category = new Category();
        $category->icon = $newIconPath;
        $category->background_image = $newBackgroundPath;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->display_at_home = $request->display_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success("Category created successfully");

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
        $newIconPath = $this->imageUpload($request, 'icon', $request->previous_icon);
        $newBackgroundPath = $this->imageUpload($request, 'background_image', $request->previous_background_image);

        $category = Category::findOrFail($id);
        $category->icon = !empty($newIconPath) ? $newIconPath : $request->previous_icon;
        $category->background_image = !empty($newBackgroundPath) ? $newBackgroundPath : $request->previous_background_image;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->display_at_home = $request->display_at_home;
        $category->status = $request->status;
        $category->save();

        toastr()->success('Category updated successfully');

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $category = Category::findOrFail($id);

            $this->deleteUploadedFile($category->icon);
            $this->deleteUploadedFile($category->background_image);

            $category->delete();

            return response(['status' => 'success', 'message' => "Category deleted successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
