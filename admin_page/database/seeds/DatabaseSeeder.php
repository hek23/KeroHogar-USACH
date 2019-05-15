<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TownsTableSeeder::class);
        $this->call(TimeBlocksTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductDiscountsTableSeeder::class);
        $this->call(PricesTableSeeder::class);
        $this->call(ProductFormatsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
    }
}
