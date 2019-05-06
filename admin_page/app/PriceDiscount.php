<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceDiscount extends Model
{
    const ITEMS_PER_PAGE = 10;
    
    public $guarded = [];
}
