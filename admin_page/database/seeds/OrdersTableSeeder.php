<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Product;
use App\TimeBlock;
use App\ProductFormat;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory(Order::class, 100)->create();

        foreach ($orders as $order) {
            $product = Product::inRandomOrder()->first();
            $productQuantity = rand(1, 30);

            if($product->is_compounded) {
                $productQuantity *= 20;
                $format = ProductFormat::where('product_id', $product->id)->inRandomOrder()->first();
                $order->products()->sync([$product->id => ['quantity' => $productQuantity, 'product_format_id' => $format->id]]);
            } else {
                $order->products()->sync([$product->id => ['quantity' => $productQuantity]]);
            }

            $timeBlocksSelected = rand(1, 4);
            $timeBlocks = TimeBlock::inRandomOrder()->take($timeBlocksSelected)->pluck('id');
            $order->delivery_blocks()->sync($timeBlocks);
            $order->calculateAmount();
            $order->save();
        }
    }
}
