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
        $products = Product::compounded()->get();
        $discounts = [20, 22, 25, 30];
        $minFill = [100, 200, 300, 400];
        $maxFill = [200, 300, 400, 500];
        foreach ($products as $product) {
            for ($i = 0; $i < 4; $i++) {
                factory(ProductDiscount::class)->create([
                    'product_id' => $product->id,
                    'discount_per_liter' => $discounts[$i],
                    'min_quantity' => $minFill[$i],
                    'max_quantity' => $maxFill[$i],
                ]);
            }
        }
    }
}
