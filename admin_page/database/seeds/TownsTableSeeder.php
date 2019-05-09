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
        factory(Town::class)->create(['name' => 'Peñalolén']);
        factory(Town::class)->create(['name' => 'Providencia']);
        factory(Town::class)->create(['name' => 'Pudahuel']);
        factory(Town::class)->create(['name' => 'Quilicura']);
        factory(Town::class)->create(['name' => 'Quinta Normal']);
    }
}
