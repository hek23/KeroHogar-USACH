<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $guarded = [];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function town() {
        return $this->belongsTo('App\Town');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }
}
