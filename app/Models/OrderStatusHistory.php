<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderStatusHistory extends Pivot
{
    use HasFactory;
    public $timestamps = false;
    
    // protected $fillable = [
    //     'order_id',
    //     'order_status_id'
    // ];

    // public function orders() {
    //     return $this->belongsTo(Order::class);
    // }

    // public function order_status() {
    //     return $this->belongsTo(OrderStatus::class);
    // }
}
