<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Freshwork\ChileanBundle\Rut;

class Client extends Model
{
    const INDIVIDUAL = 1;
    const WHOLESALER = 2;

    public $guarded = [];

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function rutFormat()
    {
        return Rut::parse($this->rut)->format();
    }

    public static function getClientTypes() {
        return [
            self::INDIVIDUAL => 'Individuo',
            self::WHOLESALER => 'Mayorista',
        ];
    }
}
