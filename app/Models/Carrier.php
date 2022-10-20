<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shipping_price'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
