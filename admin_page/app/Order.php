<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\FilterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    const ITEMS_PER_PAGE = 10;
    // Delivery status
    const PENDING_DELIVERY = 1;
    const DELIVERED = 2;
    // Payment status
    const PENDING_PAYMENT = 1;
    const PAID = 2;

    const WHOLESALER_PRICE = 100000;
    
    protected $guarded = ['amount'];

    public function products() {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'product_format_id')->withTimestamps();
    }

    public function product() {
        return $this->products()->first();
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
        $this->delivery_status = self::DELIVERED;
        $this->save();
    }

    public function paid() {
        $this->payment_status = self::PAID;
        $this->save();
    }

    public function scopeSearch($query, FilterRequest $request) {
        if($request->has('client_type') && $request->query('client_type') !== 0) {
            if($request->query('client_type') == Client::PARTICULAR) {
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
        if($request->has('delivery_status') && $request->query('delivery_status') != 0) {
            $query->where('delivery_status', $request->delivery_status);
        }
        if($request->has('payment_status') && $request->query('payment_status') != 0) {
            $query->where('payment_status', $request->payment_status);
        }
        return $query->latest();
    }

    public function deliveryStatusFormat() {
        return $this->getDeliveryStatuses()[$this->delivery_status];
    }

    public function paymentStatusFormat() {
        return $this->getPaymentStatuses()[$this->payment_status];
    }

    public static function createFromForm($validatedOrderRequest) {
        $product_id = $validatedOrderRequest['product'];
        $quantity = $validatedOrderRequest['quantity'];
        $delivery_status = $validatedOrderRequest['delivery_status'];
        $payment_status = $validatedOrderRequest['payment_status'];
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
            'delivery_status' => $delivery_status,
            'payment_status' => $payment_status,
            'amount' => 0,
        ]);

        $order->products()->sync([$product_id => ['quantity' => $quantity]]);
        $order->delivery_blocks()->sync(array_values($delivery_time));
        $order->calculateAmount();
        $order->save();
    }

    public static function getDeliveryStatuses() {
        return [
            self::PENDING_DELIVERY => 'Pendiente',
            self::DELIVERED => 'Entregado',
        ];
    }

    public static function getPaymentStatuses() {
        return [
            self::PENDING_PAYMENT => 'Pendiente',
            self::PAID => 'Pagado',
        ];
    }
}
