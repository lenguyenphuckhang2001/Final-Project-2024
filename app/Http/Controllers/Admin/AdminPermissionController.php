<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminPermissionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:permission index'])->only(['index']);
        $this->middleware(['permission:permission create'])->only(['store', 'create']);
        $this->middleware(['permission:permission update'])->only(['edit', 'update']);
        $this->middleware(['permission:permission destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    function index(AdminPermissionDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    function create(): View
    {
        $userPermissions = Permission::all()->groupBy('group_name');
        return view("admin.permission.create", compact('userPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:roles,name'],
            'permissions' => ['required']
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        toastr()->success('Role created successfully');

        return redirect()->route('admin.permission.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === "Main Admin") {
            abort(403);
        }
        $userPermissions = Permission::all()->groupBy('group_name');
        $roleHasPermission = $role->permissions->pluck('name')->toArray();
        return view('admin.permission.edit', compact('userPermissions', 'role', 'roleHasPermission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:roles,name,' . $id],
            'permissions' => ['required']
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        toastr()->success('Role updated successfully');

        return redirect()->route('admin.permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            if ($role->name === "Main Admin") {
                abort(403);
            }

            $role->delete();
            return response(['status' => 'success', 'message' => 'Role deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
