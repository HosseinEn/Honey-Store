<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight'
    ];

    public function products() {
        return $this->belongsToMany(Product::class)->as('attribute_product')
                                                   ->withPivot(['stock', 'price']);
    }
}
