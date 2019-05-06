<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const ITEMS_PER_PAGE = 10;

    public $guarded = [];

    public function orders() {
        return $this->belongsToMany('App\Order')->withPivot('quantity')->withTimestamps();
    }

    public function discounts() {
        return $this->hasMany('App\ProductDiscount');
    }

    public function scopeAllPaginated($query) {
        return $query->paginate(self::ITEMS_PER_PAGE);
    }

    public function discountsPaginated() {
        return $this->discounts()->paginate(ProductDiscount::ITEMS_PER_PAGE);
    }
}
