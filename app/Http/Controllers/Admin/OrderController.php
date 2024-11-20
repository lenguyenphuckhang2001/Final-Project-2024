<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:order index'])->only(['index', 'show']);
        $this->middleware(['permission:order update'])->only(['update']);
        $this->middleware(['permission:order destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderDataTable $dataTable): View | JsonResponse
    {
        return $dataTable->render('admin.order.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $order = Order::findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $order->payment_status = $request->payment_status;
        $order->save();

        toastr()->success('Payment status updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            Order::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
