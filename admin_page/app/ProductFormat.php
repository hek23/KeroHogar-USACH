<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFormat extends Model
{
    const ITEMS_PER_PAGE = 10;
    
    protected $guarded = [];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
