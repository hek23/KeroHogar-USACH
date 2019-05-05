<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ITEMS_PER_PAGE = 10;
    //

    public static function rowNumber($page) {
        return ($page - 1) * self::ITEMS_PER_PAGE;
    }

    public function latestOrders() {
        return $this->latesst()->paginate(self::ITEMS_PER_PAGE);
    }
}
