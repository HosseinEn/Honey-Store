<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    public function imageable() {
        return $this->morphTo();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($image) {
            Storage::delete($image->path);
        });
    }
}
