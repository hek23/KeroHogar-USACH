<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeBlock extends Model
{
    const ITEMS_PER_PAGE = 10;
    
    public $guarded = [];

    public function scopeLatestOrdersPaginated($query) {
        return $query->latest()->paginate(self::ITEMS_PER_PAGE);
    }
}
