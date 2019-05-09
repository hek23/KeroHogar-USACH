<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\FilterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    const ITEMS_PER_PAGE = 10;
    const PENDING = 1;
    const DELIVERED = 2;
    const CANCELED = 3;
    const WHOLESALER_PRICE = 100000;
    
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

    public function calculateAmount() {
        $product = $this->products[0];
        $productPrice = $product->price;
        $quantity = $product->pivot->quantity;
        $price = $productPrice * $quantity;

        foreach ($product->discounts as $discount) {
            if($quantity >= $discount->min_quantity && $quantity <= $discount->max_quantity) {
                $price -= ($quantity * $product->liters_per_unit) * $discount->discount_per_liter;
                break;
            }
        }

        $this->amount = $price;
    }

    public function delivered() {
        $this->status = self::DELIVERED;
        $this->save();
    }

    public function scopeSearch($query, FilterRequest $request) {
        if($request->has('client_type') && $request->query('client_type') !== 0) {
            if($request->query('client_type') == Client::INDIVIDUAL) {
                $query->where('amount', '<', self::WHOLESALER_PRICE);
            } elseif ($request->query('client_type') == Client::WHOLESALER) {
                $query->where('amount', '>=', self::WHOLESALER_PRICE);
            }
        }
        if($request->has('time_interval_start') && $request->query('time_interval_start') !== null) {
            $query->where('delivery_date', '>=', Carbon::parse($request->query('time_interval_start')));
        }
        if($request->has('time_interval_end') && $request->query('time_interval_end') !== null) {
            $query->where('delivery_date', '<=', Carbon::parse($request->query('time_interval_end')));
        }
        if($request->has('town_id') && $request->query('town_id') != 0) {
            $query->whereHas('address', function ($innerQuery) use ($request) {
                $innerQuery->where('town_id', $request->town_id);
            });
        }
        if($request->has('order_status') && $request->query('order_status') != 0) {
            $query->where('status', $request->order_status);
        }
        return $query->latest();
    }

    public function statusFormat() {
        return $this->getStatuses()[$this->status];
    }

    public static function createFromForm($validatedOrderRequest) {
        $product_id = $validatedOrderRequest['product'];
        $quantity = $validatedOrderRequest['quantity'];
        $status = $validatedOrderRequest['status'];
        $delivery_date = $validatedOrderRequest['delivery_date'];
        $delivery_time = $validatedOrderRequest['delivery_time'];
        $rut = $validatedOrderRequest['rut'];
        $name = $validatedOrderRequest['name'];
        $town = Town::where('id', $validatedOrderRequest['town'])->first();
        $input_address = $validatedOrderRequest['address'];

        $client = Client::whereRutEquals($rut)->first();
        if(is_null($client)) {
            $client = Client::create([
                'rut' => Client::normalizeRut($rut),
                'name' => $name,
            ]);
        }

        $address = Address::where(DB::raw('LOWER(address)'), 'like', '%' . strtolower( $input_address) . '%')->first();
        if(is_null($address)) {
            $address = Address::create([
                'client_id' => $client->id,
                'town_id' => $town->id,
                'address' => $input_address,
                'alias' => 'Hogar',
            ]);
        }

        $order = Order::create([
            'address_id' => $address->id,
            'delivery_date' => $delivery_date,
            'status' => $status,
            'amount' => 0,
        ]);

        $order->products()->sync([$product_id => ['quantity' => $quantity]]);
        $order->delivery_blocks()->sync(array_values($delivery_time));
        $order->calculateAmount();
        $order->save();
    }

    public static function getStatuses() {
        return [
            self::PENDING => 'Pendiente',
            self::DELIVERED => 'Entregado',
            self::CANCELED => 'Cancelado',
        ];
    }
}
