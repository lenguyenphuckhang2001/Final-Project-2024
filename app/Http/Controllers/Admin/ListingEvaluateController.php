<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EvaluateDataTable;
use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class ListingEvaluateController extends Controller
{
    function index(EvaluateDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.listing.evaluate.index');
    }

    //Update status of evaluate
    function update(string $id): Response
    {
        try {
            $evaluate = Evaluate::findOrFail($id);
            $evaluate->is_accepted = !$evaluate->is_accepted;
            $evaluate->save();

            return response(['status' => 'success', 'message' => 'Change status successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function destroy(string $id): Response
    {
        try {
            Evaluate::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Evaluate deteled successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
