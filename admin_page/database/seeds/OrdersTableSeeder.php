<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Product;
use App\TimeBlock;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory(Order::class, 20)->create();

        foreach ($orders as $order) {
            $product = Product::inRandomOrder()->first();
            $productQuantity = rand(1, 30);
            if(strpos($product->name, 'estanque')) $productQuantity *= 20;

            $order->products()->sync([$product->id => ['quantity' => $productQuantity]]);

            $timeBlocksSelected = rand(1, 4);
            $timeBlocks = TimeBlock::inRandomOrder()->take($timeBlocksSelected)->pluck('id');
            $order->delivery_blocks()->sync($timeBlocks);
            $order->calculateAmount();
        }
    }
}
