<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalogue extends Model
{
    use HasFactory;
    protected $fillable = [
        "siteCode",
        "modelCode",
        "modelDesc",
        "price",
        "discount",
        "status",
        "startDate",
        "endDate",
        "update_by"
    ];
}
