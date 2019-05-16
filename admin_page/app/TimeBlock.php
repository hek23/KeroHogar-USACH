<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TimeBlock extends Model
{
    const ITEMS_PER_PAGE = 10;
    
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function orders() {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }

    public function scopeOrderedBlocksPaginated($query) {
        return $query->orderBy('start', 'asc')->paginate(self::ITEMS_PER_PAGE);
    }

    public function scopeIntersecting($query, $start, $end) {
        return $query->where('end', '>', $start)
                ->where('start', '<', $end);
    }

    public function format() {
        return $this->start . ' - ' . $this->end;
    }

    public function getStartAttribute($time) {
        return Carbon::parse($time)->format('H:i');
    }

    public function getEndAttribute($time) {
        return Carbon::parse($time)->format('H:i');
    }

    public static function getAvailableBlocks($day) {
        $maxOrdersPerDay = TimeBlock::sum('max_orders');

        $orders = Order::where('delivery_date', $day)->get();

        if($orders->count() >= $maxOrdersPerDay) {
            return collect([]);
        }

        $tbs = TimeBlock::orderBy('id')->get();

        foreach ($orders as $order) {
            $orderBlocks = $order->delivery_blocks()->orderBy('id')->get();
            foreach ($orderBlocks as $orderBlock) {
                $tbs[$orderBlock->id - 1]->max_orders -= 1;
            }
        }

        foreach ($tbs as $key => $tb) {
            if($tb->max_orders <= 0) $tbs->forget($key);
        }

        /*
        For selecting only one block per order
        $tbs = TimeBlock::all();
        foreach ($tbs as $key => $tb) {
            $tb->orders_count = $tb->orders()->where('delivery_date', $day)->count();
            if ($tb->orders_count >= $tb->max_orders) $tbs->forget($key);
        }
        */

        return $tbs;
    }
}
