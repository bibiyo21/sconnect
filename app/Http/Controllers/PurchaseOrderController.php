<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderCreateRequest;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderCreateRequest $request)
    {
        $purcaseOrder = PurchaseOrder::create([
            "poNumber" => $request->get('poNumber'),
            "siteCode" => $request->get('siteCode'),
            "orderDate" => $request->get('orderDate'),
            "deliveryMode" => $request->get('deliveryMode'),
            "paymentMethod" => $request->get('paymentMethod'),
            "comment" => $request->get('comment'),
            "sales_order" => $request->get('sales_order'),
            "api_order_id" => $request->get('api_order_id'),
        ]);

        dd($purcaseOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
