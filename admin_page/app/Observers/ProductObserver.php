<?php

namespace App\Observers;

use App\Product;
use App\Price;

class ProductObserver
{
    /**
     * Listen to the Product saved event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function saved(Product $product)
    {
        if($product->isDirty('price')) {
            Price::create([
                'product_id' => $product->id,
                'price' => $product->price,
                'wholesaler' => false,
            ]);
        }
        if($product->isDirty('wholesaler_price')) {
            Price::create([
                'product_id' => $product->id,
                'price' => $product->wholesaler_price,
                'wholesaler' => true,
            ]);
        }
    }
}
