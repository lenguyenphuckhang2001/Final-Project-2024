<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListingPendingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListingPendingController extends Controller
{
    function index(ListingPendingDataTable $dataTable)
    {
        return $dataTable->render('admin.pending.index');
    }

    function update(Request $request): Response
    {
        $request->validate([
            'value' => ['boolean']
        ]);

        try {
            $listing = Listing::findOrFail($request->id);
            $listing->is_approved = $request->value;
            $listing->save();

            return response(['status' => 'success', 'message' => 'Updated successfull']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}