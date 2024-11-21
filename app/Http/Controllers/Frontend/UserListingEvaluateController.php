<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserListingEvaluateController extends Controller
{
    function index(): View
    {
        $evaluatesDashboard = Evaluate::with('listing')
            ->whereHas('listing', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->orderBy('created_at', 'asc')
            ->where('is_accepted', 1)->paginate(3);

        $evaluatesPersonal = Evaluate::with('listing')
        ->where(['user_id' => auth()->user()->id, 'is_accepted' => 1])
        ->orderBy('created_at', 'asc')
        ->paginate(3);

        return view('frontend.dashboard.evaluate.index', compact('evaluatesDashboard', 'evaluatesPersonal'));
    }

    function destroy(string $id): Response
    {
        $evaluateId = Evaluate::findOrFail($id);
        $evaluateId->where(['user_id' => auth()->user()->id, 'is_accepted' => 1]);
        try {
            $evaluateId->delete();
            return response(['status' => 'success', 'message' => "Your evaluate has been deleted successfully"]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
