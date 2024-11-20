<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SupportDataTable;
use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\View\View;

class ListingSupportController extends Controller
{
    function index(SupportDataTable $datatable): View | JsonResponse
    {
        return $datatable->render('admin.listing.support.index');
    }

    function destroy(string $id): HttpResponse
    {
        try {
            Support::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Support deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
