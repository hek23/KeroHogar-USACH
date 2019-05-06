<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $guarded = [];

    public function addresses() {
        return $this->hasMany('App\Address');
    }
}
