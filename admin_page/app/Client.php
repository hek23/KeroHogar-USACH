<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Freshwork\ChileanBundle\Rut;

class Client extends Model
{
    const PARTICULAR = 1;
    const WHOLESALER = 2;

    protected $guarded = [];

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function rutFormat()
    {
        return Rut::parse($this->rut)->format();
    }

    public function scopeWhereRutEquals($query, $rut) {
        return $query->where('rut', self::normalizeRut($rut));
    }

    public static function getClientTypes() {
        return [
            self::PARTICULAR => 'Particular',
            self::WHOLESALER => 'Distribuidor',
        ];
    }

    public static function normalizeRut($rut) {
        return Rut::parse($rut)->normalize();
    }
}
