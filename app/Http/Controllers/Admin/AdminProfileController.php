<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    function index(): View
    {
        return view('admin.profile.index');
    }

    function edit(): RedirectResponse
    {
        return redirect()->back();
    }
}
