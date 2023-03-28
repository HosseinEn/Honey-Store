<?php

namespace App\Models;

use App\Traits\sharedMethodsInModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, sharedMethodsInModels;
    
    protected $fillable = [
        'name',
        'slug',
        'type_id',
        'discount_id',
        'description', 
        'stock', 
        'rating',
        'status'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->as('cart')
                                                ->withPivot(['id', 'quantity', 'attribute_id']);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class)->as('attribute_product')
                                                     ->withPivot(['stock', 'price', 'discount_id']);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)->as('ordered')->withPivot(['quantity', 'attribute_id']);
    }

    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeSortByMostSale(Builder $query) {
        return $query
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->select(
                'products.id', 
                'products.name', 
                'products.type_id', 
                'products.slug',
                DB::raw('count(order_product.product_id) as count_sale'))
            ->groupBy('order_product.product_id')
            ->orderBy('count_sale', 'desc');
    }

    public function scopeSortByMostDiscounted(Builder $query) {
        return $query->select(
            'products.name', 
            'products.id',
            'products.slug',
            'products.type_id',
            'attributes.weight',
            'attribute_product.price',
            DB::raw('discounts.name as discount_name, discounts.value as discount_value')
        )
        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
        ->join('discounts', 'discounts.id', 'attribute_product.discount_id')
        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
        ->orderBy('discounts.value', 'desc');
    }

    public function scopeSortByMostExpensive(Builder $query) {
        return $query->select(
            'products.name', 
            'products.id', 
            'attributes.weight',
            'products.type_id',
            'products.slug',
            'attribute_product.price'
        )
        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
        ->orderBy('attribute_product.price', 'desc');
    }

    public function scopeSortByCheapest(Builder $query) {
        return  $query->select(
            'products.name', 
            'products.id',
            'products.slug',
            'products.type_id',
            'attributes.weight', 
            'attribute_product.price'
        )
        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
        ->orderBy('attribute_product.price', 'asc');
    }

    public function scopeIsActive(Builder $query) {
        return $query->where('status', 1);
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'DESC');
    }

    public function scopeSearch(Builder $query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeFilterByStatus(Builder $query, $status) {
        return $query->where('status', $status);
    }

    public function scopeFilterByDate(Builder $query, $from, $to) {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeFilterByStock(Builder $query, $stock) {
        if ($stock == '1') {
            return $query->where('stock', '>', 0);
        }
        else {
            return $query->where('stock', 0);
        }
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($product) {
            $product->attributes()->detach();
            $product->image->delete();
        });
    }
}
