<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReportDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    function index(ReportDataTable $datatable): View | JsonResponse
    {
        return $datatable->render('admin.listing.report.index');
    }
}
