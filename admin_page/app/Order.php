<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ITEMS_PER_PAGE = 10;
    const PENDING = 1;
    const DELIVERED = 2;
    
    public $guarded = [];

    public function products() {
        return $this->belongsToMany('App\Product')->withPivot('quantity')->withTimestamps();
    }

    public function address() {
        return $this->belongsTo('App\Address');
    }

    public function client() {
        return $this->address->client();
    }

    public function delivery_blocks() {
        return $this->belongsToMany('App\TimeBlock')->withTimestamps();;
    }

    public function scopeLatestOrdersPaginated($query) {
        return $query->latest()->paginate(self::ITEMS_PER_PAGE);
    }
}
