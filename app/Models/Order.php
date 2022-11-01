<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_status_id',
        // 'carrier_id',
        // 'tax_id',
        'discount_id',
        'delivery_date',
        'total_price',
        // 'total_weight',
        'invoice_no',
        'billing_no',
        'shipping_address'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function discount() {
        return $this->belongsTo(Discount::class);
    }

    public function order_status() {
        return $this->belongsTo(OrderStatus::class);
    }

    public function order_status_histories() {
        return $this->hasMany(OrderStatusHistory::class);
    }
    
    public function carrier() {
        return $this->belongsTo(Carrier::class);
    }

    public function tax() {
        return $this->belongsTo(Tax::class);
    }
}
