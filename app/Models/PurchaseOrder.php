<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'poNumber', 
        'siteCode', 
        'orderDate', 
        'deliveryMode',
        'paymentMethod',
        'comment',
        'sales_order',
        'api_order_id',
        'remarks',
        'status',
    ];
}
