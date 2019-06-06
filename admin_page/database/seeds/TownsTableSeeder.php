<?php

use Illuminate\Database\Seeder;
use App\Town;

class TownsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Town::class)->create(['name' => 'Las condes']);
        factory(Town::class)->create(['name' => 'La reina']);
        factory(Town::class)->create(['name' => 'Ñuñoa']);
        factory(Town::class)->create(['name' => 'Providencia']);
        factory(Town::class)->create(['name' => 'Vitacura']);
    }
}
