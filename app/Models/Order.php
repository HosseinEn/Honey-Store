<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'order_status_id' => 'integer',
    ];

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
        'reference_id',
        'shipping_address',
        'transaction_id',
        'description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->as('ordered')->withPivot(['quantity', 'attribute_id']);
    }

    public function discount() {
        return $this->belongsTo(Discount::class);
    }


    // public function order_status()
    // {
    //     return $this->hasManyThrough(
    //         // required
    //         OrderStatus::class, // the related model
    //         OrderStatusHistory::class, // the pivot model

    //         // optional
    //         'order_id', // the current model id in the pivot
    //         'id', // the id of related model
    //         'id', // the id of current model
    //         'order_status_id' // the related model id in the pivot
    //     );
    // }

    public function order_statuses() {
        return $this->belongsToMany(OrderStatus::class, 
                                    'order_status_histories', 
                                    'order_id', 
                                    'order_status_id')
                                    ->withPivot('status_date');
    }

    // public function order_status_histories() {
    //     return $this->hasMany(OrderStatusHistory::class);
    // }
    
    public function carrier() {
        return $this->belongsTo(Carrier::class);
    }

    public function tax() {
        return $this->belongsTo(Tax::class);
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'DESC');
    }

    // public function scopeMostSaleProduct(Builder $query) {
    //     return $query->orderBy(static::product_id, 'DESC');
    // }

}
