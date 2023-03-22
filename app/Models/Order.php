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
        'discount_id',
        'total_price',
        'price_with_discount',
        'invoice_no',
        'reference_id',
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

    public function order_statuses() {
        return $this->belongsToMany(OrderStatus::class, 
                                    'order_status_histories', 
                                    'order_id', 
                                    'order_status_id')
                                    ->withPivot('status_date');
    }
    
    public function carrier() {
        return $this->belongsTo(Carrier::class);
    }

    public function tax() {
        return $this->belongsTo(Tax::class);
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'DESC');
    }

    public function scopeSearch(Builder $query, $search_key) {
        return $query->where('invoice_no', 'like', '%' . $search_key . '%')
                    ->orWhereHas('user', function($query) use ($search_key) {
                        return $query->where('name', 'like', '%' . $search_key . '%')
                                    ->orWhere('phone', 'like', '%' . $search_key . '%')
                                    ->orWhere('email', 'like', '%' . $search_key . '%')
                                    ->orWhere('address', 'like', '%' . $search_key . '%');
                    });
    }

    public function scopeFilterByStatus(Builder $query, $status) {
        return $query->where('order_status_id', $status);
    }

    public function scopeFilterByDate(Builder $query, $from, $to) {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    // public function scopeMostSaleProduct(Builder $query) {
    //     return $query->orderBy(static::product_id, 'DESC');
    // }

}
