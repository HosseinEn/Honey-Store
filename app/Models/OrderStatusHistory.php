<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_status_id'
    ];

    public function orders() {
        return $this->belongsTo(Order::class);
    }

    public function order_status() {
        return $this->belongsTo(OrderStatus::class);
    }
}
