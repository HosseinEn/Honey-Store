<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function orders() {
        return $this->belongsToMany(Order::class, 
                                    'order_status_histories', 
                                    'order_id', 
                                    'order_status_id')
                                    ->withPivot('status_date');
    }

    // public function order_status_histories() {
    //     return $this->hasMany(OrderStatusHistory::class);
    // }
}
