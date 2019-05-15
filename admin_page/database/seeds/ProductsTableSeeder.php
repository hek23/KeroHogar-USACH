<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class)->create([
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        factory(Product::class)->create([
            'name' => 'Trasvasijador de combustible',
            'price' => 10000,
            'wholesaler_price' => 10000,
            'is_compounded' => false,
        ]);
        factory(Product::class)->create([
            'name' => 'Otros productos que se pueden agregar',
            'price' => 100000,
            'wholesaler_price' => 100000,
            'is_compounded' => false,
        ]);
    }
}
