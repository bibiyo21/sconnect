<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseOrderExports implements FromCollection, ShouldAutoSize, WithHeadings
{
    public function headings(): array
    {
        return [
            'Status',
            'Sales Order',
            'Billing Document',
            'Order Date',
            'PO Number',
            'Model Code',
            'Order Qty',
            'Invoice Qty',
            'Invoice Price',
            'Total Price',
            'Site Code',
            'Delivery Mode',
            'Payment Method',
            'Comment',
            'Updated By',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = "
            purchase_orders.status,
            purchase_orders.sales_order,
            purchase_orders.billing_document,
            purchase_orders.orderDate,
            purchase_orders.poNumber,
            GROUP_CONCAT(purchase_order_items.modelCode SEPARATOR ' ') as modelCode,
            SUM(purchase_order_items.orderQuantity) as orderQuantity,
            SUM(purchase_order_items.invoiceQuantity) as invoiceQuantity,
            SUM(purchase_order_items.invoicePrice) as invoicePrice,
            SUM(purchase_order_items.totalPrice) as totalPrice,
            purchase_orders.siteCode,
            purchase_orders.deliveryMode,
            purchase_orders.paymentMethod,
            purchase_orders.comment,
            users.name as userName
        ";
        
        $purchaseOrders = DB::table('purchase_orders')
            ->select(
                DB::raw($query)
            )
            ->join('purchase_order_items', 'purchase_order_items.purchase_order_id', '=', 'purchase_orders.id')
            ->join('users', 'users.id', '=', 'purchase_orders.update_by', 'left')
            ->groupBy('purchase_orders.id');
        return $purchaseOrders->get();
    }
}
