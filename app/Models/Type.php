<?php

namespace App\Models;

use App\Traits\sharedMethodsInModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory, sharedMethodsInModels;

    protected $fillable = ['name', 'slug', 'description'];

    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function products() {
        return $this->hasMany(Product::class);
    }
}
