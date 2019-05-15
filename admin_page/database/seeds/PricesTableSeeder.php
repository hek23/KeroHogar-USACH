<?php

use Illuminate\Database\Seeder;
use App\Price;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Price::class)->create([
            'product_id' => 1,
            'price' => 748,
            'wholesaler' => false,
        ]);
        factory(Price::class)->create([
            'product_id' => 1,
            'price' => 648,
            'wholesaler' => true,
        ]);
        factory(Price::class)->create([
            'product_id' => 2,
            'price' => 10000,
            'wholesaler' => false,
        ]);
        factory(Price::class)->create([
            'product_id' => 2,
            'price' => 10000,
            'wholesaler' => true,
        ]);
        factory(Price::class)->create([
            'product_id' => 3,
            'price' => 100000,
            'wholesaler' => false,
        ]);
        factory(Price::class)->create([
            'product_id' => 3,
            'price' => 100000,
            'wholesaler' => true,
        ]);
    }
}
