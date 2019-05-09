<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    const ITEMS_PER_PAGE = 10;
    
    public $guarded = [];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function formatDiscount() {
        return '$' . $this->discount_per_liter . '/litro';
    }

    public function formatMinQuantity() {
        return $this->min_quantity . ' ' . $this->product->plural;
    }

    public function formatMaxQuantity() {
        return $this->max_quantity . ' ' . $this->product->plural;
    }
}
