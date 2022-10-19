<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_status_id',
        'carrier_id',
        'tax_id',
        'discount_id',
        'delivery_date',
        'total_price',
        'total_weight',
        'invoice_no',
        'shipping_address'
    ];
}
