<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderCreateRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PurchaseOrderController extends Controller
{
    const PO_UPDATE_INTERFACE = 'retailerpoapi/updatestatus';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = "
            purchase_orders.*,
            users.name as userName,
            GROUP_CONCAT(purchase_order_items.modelCode SEPARATOR ' ') as modelCode,
            SUM(purchase_order_items.orderQuantity) as orderQuantity,
            SUM(purchase_order_items.invoiceQuantity) as invoiceQuantity,
            SUM(purchase_order_items.invoicePrice) as invoicePrice,
            SUM(purchase_order_items.totalPrice) as totalPrice
        ";

        switch (getenv('DB_CONNECTION')) {
            case "pgsql":
                $query = "
                    purchase_orders.*,
                    users.name as userName,
                    STRING_AGG(lower('purchase_order_items.modelCode'), ', ') as modelCode,
                    CAST(SUM(lower('purchase_order_items.orderQuantity')) AS double) as orderQuantity,
                    SUM(lower('purchase_order_items.invoiceQuantity')) as invoiceQuantity,
                    SUM(lower('purchase_order_items.invoicePrice')) as invoicePrice,
                    SUM(lower('purchase_order_items.totalPrice')) as totalPrice
                ";
                break;
        }
        // dd($query);
        $purchaseOrders = DB::table('purchase_orders')
            ->select(
                DB::raw($query)
            )
            ->join('purchase_order_items', 'purchase_order_items.purchase_order_id', '=', 'purchase_orders.id')
            ->join('users', 'users.id', '=', 'purchase_orders.update_by', 'left')
            ->groupBy('purchase_orders.id');
        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $purchaseOrders = $purchaseOrders
                ->where(function ($query) use ($keyword) {
                    $query->where('poNumber', 'like', '%'.$keyword.'%')
                        ->orWhere('siteCode', 'like', '%'.$keyword.'%')
                        ->orWhere('orderDate', 'like', '%'.$keyword.'%')
                        ->orWhere('deliveryMode', 'like', '%'.$keyword.'%')
                        ->orWhere('paymentMethod', 'like', '%'.$keyword.'%')
                        ->orWhere('sales_order', 'like', '%'.$keyword.'%')
                        ->orWhere('comment', 'like', '%'.$keyword.'%')
                        ->orWhere('billing_document', 'like', '%'.$keyword.'%')
                        ;
                });
        }
        
        $purchaseOrders = $purchaseOrders->paginate($request->get('limit', 100));

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
        $userId = auth()->user()->id;
        $purcaseOrder = PurchaseOrder::updateOrCreate(
            ["poNumber" => $request->get('poNumber')],
            [
                "siteCode" => $request->get('siteCode'),
                "orderDate" => $request->get('orderDate'),
                "deliveryMode" => $request->get('deliveryMode'),
                "paymentMethod" => $request->get('paymentMethod'),
                "comment" => $request->get('comment'),
                "sales_order" => $request->get('sales_order'),
                "api_order_id" => $request->get('api_order_id'),
                "update_by" => $userId
            ]
        );

        $purchaseOrderId = $purcaseOrder->id;
        foreach ($request->get('items') as $value) {
            $price = doubleval($value['price']);
            $discount = doubleval($value['discount']);
            $quantity = intval($value['orderQuantity']);
            $discountedPrice = !empty($value['discountedPrice']) ? $value['discountedPrice'] : $price - $discount;
            $totalPrice = !empty($value['totalPrice']) ? $value['totalPrice'] : $discountedPrice * $quantity;
            
            PurchaseOrderItem::create(
                [
                    'purchase_order_id' => $purchaseOrderId,
                    'bundleCode' => $value['bundleCode'] ?? null,
                    'orderQuantity' => $quantity,
                    'price' =>  $price,
                    'discount' => $discount,
                    'discountedPrice' => $discountedPrice,
                    'totalPrice' => $totalPrice,
                    'taxcode' => $value['taxcode'],
                    'modelCode' => $value['modelCode'],
                    "update_by" => $userId
                ]
            );
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

        $payloadSamsung = [
            "poNumber" => $purchaseOrder->poNumber,
            "status" => $request->get('status', ''),
            "remarks" => trim($request->get('remarks', '')),
            'items' => []
        ];

        foreach ($rawPayload['item'] as $itemId => $item) {
            $purchaseOrderItem = PurchaseOrderItem::find($itemId);; 
           
            $price = doubleval($item['price']);
            $discount = doubleval($item['discount']);
            $quantity = intval($item['orderQuantity']);
            $deliveryDate = Carbon::parse($item['deliveryDate'])->format('Ymd');

            array_push($payloadSamsung['items'], [
                "modelCode" => $purchaseOrderItem->modelCode,
                "orderQuantity" => $quantity,
                "invoiceQuantity" => $item['invoiceQuantity'],
                "orderPrice" => $price,
                "invoicePrice" => $item['invoicePrice'],
                "deliveryDate" => $deliveryDate
            ]);
            
            // $payloadSamsung['items'][] =  [
            //     "modelCode" => $purchaseOrderItem->modelCode,
            //     "orderQuantity" => $quantity,
            //     "invoiceQuantity" => $item['invoiceQuantity'],
            //     "orderPrice" => $price,
            //     "invoicePrice" => $item['invoicePrice'],
            //     "deliveryDate" => $deliveryDate
            // ];

            $payload['items'][$itemId] =  [
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
            ->post(env("SAMSUNG_SCONNECT_API") . self::PO_UPDATE_INTERFACE, $payloadSamsung);

        if ($response->failed()) {
            $apiErrorResponse = json_decode($response->body(), true);
            return redirect()->back()->withErrors([
                "api_error" => $apiErrorResponse['errors']
            ]);
        }

        $purchaseOrder->billing_document = $payload['billing_document'];
        $purchaseOrder->sales_order = $payload['sales_order'];
        $purchaseOrder->date_sent = Carbon::now()->format('Y-m-d');
        $purchaseOrder->status = $payload['status'];
        $purchaseOrder->remarks = $payload['remarks'];
        $purchaseOrder->update_by = auth()->user()->id;

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
            $purchaseOrderItem->update_by = auth()->user()->id;

            $purchaseOrderItem->save();
        }

        return redirect()->back()->with(
            'success',
            'Purchase Order Updated'
        );
    }
}
