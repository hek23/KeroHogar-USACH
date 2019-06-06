<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Product;
use App\TimeBlock;
use App\ProductFormat;
use Illuminate\Support\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 500)->create();

        $orders = Order::all();

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
            $timeBlocks = TimeBlock::getAvailableBlocks($order->delivery_date)->shuffle()->slice(0, $timeBlocksSelected)->pluck('id');
            //$timeBlocks = TimeBlock::inRandomOrder()->take($timeBlocksSelected)->pluck('id');
            if($timeBlocks->isEmpty()) {
                $order->delete();
            } else {
                $order->delivery_blocks()->sync($timeBlocks);
                $order->calculateAmount();
                $order->save();
            }
        }
    }
}
