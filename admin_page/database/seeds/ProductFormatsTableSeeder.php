<?php

use Illuminate\Database\Seeder;
use App\ProductFormat;
use App\Product;

class ProductFormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::compounded()->first();

        factory(ProductFormat::class)->create([
            'product_id' => $product->id,
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);
        factory(ProductFormat::class)->create([
            'product_id' => $product->id,
            'name' => 'Intercambio de bidón',
            'added_price' => 0,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);
        factory(ProductFormat::class)->create([
            'product_id' => $product->id,
            'name' => 'Relleno de estanque',
            'added_price' => 0,
            'capacity' => 0,
            'minimum_quantity' => 100,
        ]);
    }
}
