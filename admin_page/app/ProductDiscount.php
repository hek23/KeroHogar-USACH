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
}
