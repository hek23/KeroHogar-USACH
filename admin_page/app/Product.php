<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const ITEMS_PER_PAGE = 10;

    protected $guarded = [];

    public function orders() {
        return $this->belongsToMany('App\Order')->withPivot('quantity', 'product_format_id')->withTimestamps();
    }

    public function discounts() {
        return $this->hasMany('App\ProductDiscount');
    }

    public function formats() {
        return $this->hasMany('App\ProductFormat');
    }

    public function historical_prices() {
        return $this->hasMany('App\Price')->where('wholesaler', false);
    }

    public function historical_wholesaler_prices() {
        return $this->hasMany('App\Price')->where('wholesaler', true);
    }

    public function scopeAllPaginated($query) {
        return $query->paginate(self::ITEMS_PER_PAGE);
    }

    public function scopeCompounded($query) {
        return $query->where('is_compounded', true);
    }

    public function discountsPaginated() {
        return $this->discounts()->orderBy('min_quantity','asc')->paginate(ProductDiscount::ITEMS_PER_PAGE);
    }

    public function formatsPaginated() {
        return $this->formats()->orderBy('id','asc')->paginate(ProductFormat::ITEMS_PER_PAGE);
    }
}
