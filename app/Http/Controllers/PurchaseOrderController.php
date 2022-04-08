<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderCreateRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PurchaseOrderController extends Controller
{
    const PO_UPDATE_INTERFACE = 'retailerpoapi/updatestatus';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::all();

        return view('samsung.purchase-order.index', compact('purchaseOrders'));
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

        $purchaseOrderId = $purcaseOrder->id;
        foreach ($request->get('items') as $key => $value) {
            $price = doubleval($value['price']);
            $discount = doubleval($value['discount']);
            $quantity = intval($value['orderQuantity']);
            $discountedPrice = !empty($value['discountedPrice']) ? $value['discountedPrice'] : $price - $discount;
            $totalPrice = !empty($value['totalPrice']) ? $value['totalPrice'] : $discountedPrice * $quantity;
            
            $purchaseOrderItem = PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrderId,
                'bundleCode' => $value['bundleCode'],
                'modelCode' => $value['modelCode'],
                'orderQuantity' => $quantity,
                'price' =>  $price,
                'discount' => $discount,
                'discountedPrice' => $discountedPrice,
                'totalPrice' => $totalPrice,
                'taxcode' => $value['taxcode'],
            ]);

            // $purchaseOrderItemId = $purchaseOrderItem->id;
        }

        return response()->json([
            'resultCode' => 'Success',
            'message' => "Order Created"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchaseOrder->id)->get()->all();

        return view('samsung.purchase-order.edit', compact('purchaseOrder', 'purchaseOrderItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderUpdateRequest $request, PurchaseOrder $purchaseOrder)
    {
        $rawPayload = $request->all();

        $payload = [
            "billing_document" => $request->get('billing_document', ''),
            "sales_order" => $request->get('sales_order', ''),
            "status" => $request->get('status', ''),
            "remarks" => trim($request->get('remarks', '')),
        ];

        foreach ($rawPayload['item'] as $itemId => $item) {
            $purchaseOrderItem = PurchaseOrderItem::find($itemId);; 
           
            $price = doubleval($item['price']);
            $discount = doubleval($item['discount']);
            $quantity = intval($item['orderQuantity']);
            $deliveryDate = Carbon::parse($item['deliveryDate'])->format('Ymd');
            
            $payload['items'][] =  [
                "modelCode" => $purchaseOrderItem->modelCode,
                "orderQuantity" => $quantity,
                "invoiceQuantity" => $item['invoiceQuantity'],
                "orderPrice" => $price,
                "invoicePrice" => $item['invoicePrice'],
                "deliveryDate" => $deliveryDate
            ];
        }
        
        $response = Http::withToken(session('samsung_token'))
            ->acceptJson()
            ->post(env("SAMSUNG_SCONNECT_API") . self::PO_UPDATE_INTERFACE, $payload);

        if ($response->failed()) {
            return redirect()->back()->withErrors([
                "api_error" => "Cannot Connect to Samsung API. There something wrong with your request."
            ]);
        }

        $purchaseOrder->billing_document = $payload['billing_document'];
        $purchaseOrder->sales_order = $payload['sales_order'];
        $purchaseOrder->date_sent = Carbon::now()->format('Y-m-d');
        $purchaseOrder->status = $payload['status'];
        $purchaseOrder->remarks = $payload['remarks'];

        $purchaseOrder->save();

        foreach ($request->get('item') as $itemId => $purchaseItem) {
            $purchaseOrderItem = PurchaseOrderItem::find($itemId);

            $price = doubleval($purchaseItem['price']);
            $discount = doubleval($purchaseItem['discount']);
            $quantity = intval($purchaseItem['orderQuantity']);
            $discountedPrice = $price - $discount;
            $totalPrice = $discountedPrice * $quantity;
            $deliveryDate = Carbon::parse($purchaseItem['deliveryDate'])->format('Ymd');

            $purchaseOrderItem->orderQuantity = $quantity;
            $purchaseOrderItem->invoiceQuantity = $purchaseItem['invoiceQuantity'];
            $purchaseOrderItem->invoicePrice = $purchaseItem['invoicePrice'];
            $purchaseOrderItem->price = $price;
            $purchaseOrderItem->discount = $discount;
            $purchaseOrderItem->taxcode = $purchaseItem['taxcode'];
            $purchaseOrderItem->totalPrice = $totalPrice;
            $purchaseOrderItem->deliveryDate = $deliveryDate;

            $purchaseOrderItem->save();
        }

        return redirect()->back()->with(
            'success',
            'Purchase Order Updated'
        );
    }
}
