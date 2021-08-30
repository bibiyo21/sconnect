<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order', 
        'billing_document', 
        'api_order_id', 
        'response',
        'is_return'
    ];
}
