<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Orders;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('export')) {
            return Excel::download(new OrdersExport, 'orders.xlsx');
        }

        $orders = Orders::all();

        return view('orders.index', compact('orders'));
    }
}
