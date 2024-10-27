<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\View\View;
use Response;

class ReportController extends Controller
{
    function index(ReportDataTable $datatable): View | JsonResponse
    {
        return $datatable->render('admin.listing.report.index');
    }

    function destroy(string $id): HttpResponse
    {
        try {
            Report::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deteled report successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
