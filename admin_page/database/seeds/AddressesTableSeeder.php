<?php

use Illuminate\Database\Seeder;
use App\Client;
use App\Address;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            factory(Address::class, rand(1, 3))->create(['client_id' => $client->id]);
        }
    }
}
