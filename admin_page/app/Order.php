<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\FilterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    
    protected $guarded = [];

    public function products() {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'product_format_id')->withTimestamps();
    }

    public function format() {
        return ProductFormat::find($this->product()->pivot->product_format_id);
    }

    public function product() {
        return $this->products()->first();
    }

    public function getFormatAttribute() {
        return $this->format();
    }

    public function getProductAttribute() {
        return $this->product();
    }

    public function address() {
        return $this->belongsTo('App\Address');
    }

    public function client() {
        return $this->address->client();
    }

    public function delivery_blocks() {
        return $this->belongsToMany('App\TimeBlock')->withTimestamps()->orderBy('start');
    }

    public function calculateAmount() {
        $product = $this->product;
        if($this->client->wholesaler) {
            $productPrice = $product->wholesaler_price;
        } else {
            $productPrice = $product->price;
        }
        $quantity = $product->pivot->quantity;
        $price = $productPrice * $quantity;

        $productFormat = $this->format;
        if(!is_null($productFormat) && $productFormat->capacity > 0) {
            $price += ceil(($quantity / $productFormat->capacity)) * $productFormat->added_price;
        }

        $discount = $product->discounts()->where('min_quantity', '<=', $quantity)->orderBy('min_quantity', 'desc')->first();
        if(!is_null($discount) && !$this->client->wholesaler) {
            $price -= $quantity * $discount->discount_per_liter;
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
        $query->filterByClientType($request->query('client_type', null));
        $query->filterByIntervalStartDate($request->query('time_interval_start', null));
        $query->filterByIntervalEndDate($request->query('time_interval_end', null));
        $query->filterByTown($request->query('town_id', null));
        $query->filterByTimeBlock($request->query('time_block_id', null));
        $query->filterByDeliveryStatus($request->query('delivery_status', null));
        $query->filterByPaymentStatus($request->query('payment_status', null));

        return $query->latest();
    }

    public function scopeFilterByClientType($query, $client_type) {
        if(!is_null($client_type) && $client_type > 0) {
            $query->whereHas('address', function ($addressQuery) use ($client_type) {
                $addressQuery->whereHas('client', function ($innerQuery) use ($client_type) {
                    $innerQuery->where('wholesaler', Client::WHOLESALER == $client_type);
                });
            });
        }
    }

    public function scopeFilterByIntervalStartDate($query, $time_interval_start) {
        if(!is_null($time_interval_start)) {
            $query->where('delivery_date', '>=', Carbon::parse($time_interval_start));
        }
    }

    public function scopeFilterByIntervalEndDate($query, $time_interval_end) {
        if(!is_null($time_interval_end)) {
            $query->where('delivery_date', '<=', Carbon::parse($time_interval_end));
        }
    }

    public function scopeFilterByTown($query, $town_id) {
        if(!is_null($town_id) && $town_id > 0) {
            $query->whereHas('address', function ($innerQuery) use ($town_id) {
                $innerQuery->where('town_id', $town_id);
            });
        }
    }

    public function scopeFilterByTimeBlock($query, $time_block_id) {
        if(!is_null($time_block_id) && $time_block_id > 0) {
            $query->whereHas('delivery_blocks', function ($innerQuery) use ($time_block_id) {
                $innerQuery->where('time_block_id', $time_block_id);
            });
        }
    }

    public function scopeFilterByDeliveryStatus($query, $delivery_status) {
        if(!is_null($delivery_status) && $delivery_status > 0) {
            $query->where('delivery_status', $delivery_status);
        }
    }

    public function scopeFilterByPaymentStatus($query, $payment_status) {
        if(!is_null($payment_status) && $payment_status > 0) {
            $query->where('payment_status', $payment_status);
        }
    }

    public function deliveryStatusFormat() {
        return $this->getDeliveryStatuses()[$this->delivery_status];
    }

    public function paymentStatusFormat() {
        return $this->getPaymentStatuses()[$this->payment_status];
    }

    public function productNameFormat() {
        if(!is_null($this->format)) {
            return $this->product->name . ' (' . $this->format->name . ')';
        }
        return $this->product->name;
    }

    public static function createFromForm($validatedOrderRequest) {
        $product_id = $validatedOrderRequest['product'];
        $product_format_id = $validatedOrderRequest['format'];
        $quantity = $validatedOrderRequest['quantity'];
        $delivery_status = $validatedOrderRequest['delivery_status'];
        $payment_status = $validatedOrderRequest['payment_status'];
        $delivery_date = $validatedOrderRequest['delivery_date'];
        $delivery_time = $validatedOrderRequest['delivery_time'];
        $rut = $validatedOrderRequest['rut'];
        $name = $validatedOrderRequest['name'];
        $email = $validatedOrderRequest['email'];
        $phone = $validatedOrderRequest['phone'];
        $wholesaler = $validatedOrderRequest['wholesaler'];
        $town = Town::where('id', $validatedOrderRequest['town'])->first();
        $input_address = $validatedOrderRequest['address'];

        if (!is_null($rut)) {
            $client = Client::whereRutEquals($rut)->first();
            if (is_null($client)) {
                $client = Client::make([
                    'rut' => Client::normalizeRut($rut),
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'wholesaler' => $wholesaler,
                    'password' => Hash::make(str_random(20)),
                ]);
            }
        } else {
            $client = Client::make([
                'rut' => $rut,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'wholesaler' => $wholesaler,
                'password' => Hash::make(str_random(20)),
            ]);
        }
        

        $address = Address::where(DB::raw('LOWER(address)'), 'like', '%' . strtolower($input_address) . '%')->first();
        if(is_null($address)) {
            $client->save();

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

        $order->products()->sync([$product_id => ['quantity' => $quantity, 'product_format_id' => $product_format_id]]);
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
