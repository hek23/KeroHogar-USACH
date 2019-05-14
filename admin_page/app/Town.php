<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $guarded = [];

    public function addresses() {
        return $this->hasMany('App\Address');
    }
}
