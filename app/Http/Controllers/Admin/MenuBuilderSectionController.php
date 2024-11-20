<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuBuilderSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:menu builder index'])->only(['index']);
    }

    function index(): View
    {
        return view('admin.menu-builder.index');
    }
}
