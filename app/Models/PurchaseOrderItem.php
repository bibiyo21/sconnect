<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id', 
        'bundleCode', 
        'model_code', 
        'orderQuantity',
        'invoiceQuantity',
        'invoicePrice',
        'deliveryDate',
        'price',
        'discount',
        'discountedPrice',
        'totalPrice',
        'taxcode',
        'update_by',
    ];
}
