<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Freshwork\ChileanBundle\Rut;

class Client extends Model
{
    public $guarded = [];

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function rutFormat()
    {
        return Rut::parse($this->rut)->format();
    }
}
