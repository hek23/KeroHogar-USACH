<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductDiscount;

class ProductDiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $discounts = [20, 22, 25, 28, 30];
        $min = [5, 11, 16, 21, 26];
        $max = [10, 15, 20, 25, 30];
        $minFill = [100, 201, 301, 401, 501];
        $maxFill = [200, 300, 400, 500, 600];
        foreach ($products as $product) {
            if(strpos($product->name, 'estanque') !== false) {
                for ($i = 0; $i < 5; $i++) {
                    factory(ProductDiscount::class)->create([
                        'product_id' => $product->id,
                        'discount_per_liter' => $discounts[$i],
                        'min_quantity' => $minFill[$i],
                        'max_quantity' => $maxFill[$i],
                    ]);
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    factory(ProductDiscount::class)->create([
                        'product_id' => $product->id,
                        'discount_per_liter' => $discounts[$i],
                        'min_quantity' => $min[$i],
                        'max_quantity' => $max[$i],
                    ]);
                }
            }
        }
    }
}
