<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionUserRoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionUserRoleStoreRequest;
use App\Http\Requests\Admin\PermissionUserRoleUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class PermissionUserRoleController extends Controller
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
    public function index(PermissionUserRoleDataTable $datatable): View | JsonResponse
    {
        return $datatable->render('admin.permission.user-role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.permission.user-role.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionUserRoleStoreRequest $request): RedirectResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = 'admin';
        $user->save();

        $user->syncRoles($request->role);

        toastr()->success('User role created successfully');

        return redirect()->route('admin.user-role.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        if ($user->getRoleNames()->first() === "Main Admin") {
            abort(403);
        }
        $roles = Role::all();
        return view('admin.permission.user-role.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUserRoleUpdateRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $request->filled('password') ?? $user->password = bcrypt($request->password);
        $user->user_type = 'admin';
        $user->save();

        $user->syncRoles($request->role);

        toastr()->success('User role updated successfully');

        return redirect()->route('admin.user-role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $user = User::findOrFail($id);

            if ($user->getRoleNames()->first() === "Main Admin") {
                abort(403);
            }

            $user->delete();
            return response(['status' => 'success', 'message' => 'Role deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
