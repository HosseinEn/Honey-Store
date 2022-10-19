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
        'rating'
    ];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }
}
