<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionDataTable;
use App\DataTables\RoleUserPermissionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleUserPermissionController extends Controller
{
    function index(RoleUserPermissionDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.permission.index');
    }

    function create():View
    {
        return view("admin.permission.create");
    }
}
