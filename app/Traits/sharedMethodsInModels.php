<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait sharedMethodsInModels{

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'DESC');
    }


}