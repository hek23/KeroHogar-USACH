<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPrice extends Model
{
    const ITEMS_PER_PAGE = 10;

    public $guarded = [];

    public function discounts() {
        return $this->hasMany('App\PriceDiscount');
    }

    public function scopeAllPaginated($query) {
        return $query->paginate(self::ITEMS_PER_PAGE);
    }

    public function discountsPaginated() {
        return $this->discounts()->paginate(PriceDiscount::ITEMS_PER_PAGE);
    }
}
