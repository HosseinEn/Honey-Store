<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'type_id', 
        'description', 
        'stock', 
        'rating',
        'status'
    ];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('quantity');
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class)->withPivot(['stock', 'price']);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    public function discount() {
        return $this->belongsTo(Discount::class);
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }
}
