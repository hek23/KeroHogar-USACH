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
            'name' => 'Compra de bidón de parafina',
            'price' => '24000',
            'unit' => 'bidón',
            'plural' => 'bidones',
            'liters_per_unit' => '20',
            'minimum_amount' => '1',
        ]);
        factory(Product::class)->create([
            'name' => 'Intercambio de bidón de parafina',
            'price' => '22000',
            'unit' => 'bidón',
            'plural' => 'bidones',
            'liters_per_unit' => '20',
            'minimum_amount' => '1',
        ]);
        factory(Product::class)->create([
            'name' => 'Relleno de estanque de parafina',
            'price' => '1000',
            'unit' => 'litro',
            'plural' => 'litros',
            'liters_per_unit' => '1',
            'minimum_amount' => '100',
        ]);
    }
}
