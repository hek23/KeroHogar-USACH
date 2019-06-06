<?php

function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}

function raw($class, $attributes = [])
{
    return factory($class)->raw($attributes);
}

function get_random($model)
{   
    $result = $model::inRandomOrder()->first();
    return $result !== null ? $result : create($model);
    return $model::inRandomOrder()->first();
}

function create_product_for_orders()
{
    $orders = App\Order::all();
    foreach ($orders as $order) {
        $product = create(App\Product::class);
        $productQuantity = rand(1, 30);
        if ($product->is_compounded) {
            $productQuantity *= 20;
            $format = App\ProductFormat::where('product_id', $product->id)->inRandomOrder()->first();
            if($format === null) {
                $format = create(App\ProductFormat::class, [
                    'product_id' => $product->id,
                ]);
            }
            $order->products()->sync([$product->id => ['quantity' => $productQuantity, 'product_format_id' => $format->id]]);
        } else {
            $order->products()->sync([$product->id => ['quantity' => $productQuantity]]);
        }

    }
}
